<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\MembershipPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;

class DonationController extends Controller
{
    // finance/donations.blade.php (main)
    public function index()
    {
        $totalConfirmedDonations = Donation::where('status', 'Confirmed')->sum('amount');
        $confirmedDonations = Donation::where('status', 'Confirmed')->count();
        $totalPendingDonations = Donation::where('status', 'Pending')->sum('amount');
        $pendingDonations = Donation::where('status', 'Pending')->count();
        $donations = Donation::latest()->paginate(10);

        return view('finance.donations', compact(
            'totalConfirmedDonations',
            'confirmedDonations',
            'totalPendingDonations',
            'pendingDonations',
            'donations'
        ));
    }

    // finance/donations.blade.php (main)
    public function updateDonationStatus(Donation $donation)
    {
        // Still undecided kung magdadagdag pa ng status na Decline? Rejected? Cancelled?
        // Ang purpose lang naman kase pag confirm is indicator na talagang nareceived na yung donation.
        $donation->update([
            'status' => 'Confirmed',
            'confirmed_at' => now(),
            'recorded_by' => Auth::id(),
        ]);
        return redirect()->back()->with('toast', [
            'message' => 'Donation status updated successfully!',
            'type' => 'success',
        ]);
    }

    // finance/modals/addDonationModal.blade.php (partial)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => 'nullable|string|max:255',
            // [
            //     'nullable',
            //     'string',
            //     'max:255',
            //     function ($attribute, $value, $fail) {
            //         if ($value && $value !== 'N/A' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            //             $fail('The email must be either "N/A" or a valid email address.');
            //         } // dapat real-time (sana malaman - frontend side)
            //     },
            // ],
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|max:100',
            'donation_date' => 'required|date',
            'receipt' => 'nullable|file|mimes:jpeg,jpg,png,gif,pdf|max:10240',
            'is_anonymous' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Clean up email value - if it's "N/A", set it to null
        if (isset($validated['donor_email']) && $validated['donor_email'] === 'N/A') {
            $validated['donor_email'] = null;
        }

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $sanitizedName = preg_replace('/[^A-Za-z0-9\-]/', '', $validated['donor_name'] ?? 'Anonymous');
            $dateString = date('Ymd', strtotime($validated['donation_date']));
            $timestamp = time();
            $extension = $file->getClientOriginalExtension();
            $newFilename = "{$sanitizedName}_{$dateString}_{$timestamp}.{$extension}";
            $receiptPath = $file->storeAs('uploads/donation_proof', $newFilename, 'public');
        }
        // [DonorName]_[YYYYMMDD]_[timestamp].jpg
        // JericDelaCruz_20240605_1717581234.jpg

        Donation::create([
            'donor_name' => $validated['donor_name'] ?? null,
            'donor_email' => $validated['donor_email'] ?? null,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'donation_date' => $validated['donation_date'],
            'receipt_url' => $receiptPath,
            'status' => 'Pending',
            'recorded_by' => Auth::id(), // wala munang confirmed_at (its in the updateDonationStatus)
            'is_anonymous' => $request->boolean('is_anonymous', false),
            'notes' => $validated['notes'] ?? null,
        ]);// Pending status are donations that have been reported/entered not yet verified or received.

        return redirect()->route('finance.index')->with('toast', [
            'message' => 'Donation added successfully!',
            'type' => 'success',
        ]);
    }

    /**
     * Download specific donation as PDF
     */
    public function downloadSpecificDonation(Donation $donation)
    {
        try {
            $data = [
                'donation' => $donation,
                'recorder' => $donation->recorder,
                'organization' => 'Youmanitarian International',
                'generated_at' => now()->format('F j, Y h:i A'),
            ];

            $pdf = Pdf::loadView('finance.pdfs.donation', $data);

            $filename = 'donation_' . ($donation->donor_name ?? 'anonymous') . '_' .
                       $donation->donation_date->format('Y-m-d') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            // Fallback to CSV if PDF generation fails
            return $this->downloadSpecificDonationAsCSV($donation);
        }
    }

    /**
     * Download specific donation as CSV (fallback)
     */
    private function downloadSpecificDonationAsCSV(Donation $donation)
    {
        $filename = 'donation_' . ($donation->donor_name ?? 'anonymous') . '_' .
                   $donation->donation_date->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($donation) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'ID', 'Donor Name', 'Donor Email', 'Amount', 'Payment Method',
                'Donation Date', 'Status', 'Anonymous', 'Notes', 'Recorded By',
                'Confirmed At', 'Created At'
            ]);

            // CSV Data
            fputcsv($file, [
                $donation->id,
                $donation->is_anonymous ? 'Anonymous' : ($donation->donor_name ?? 'N/A'),
                $donation->donor_email ?? 'N/A',
                number_format((float)($donation->amount ?? 0), 2),
                $donation->payment_method,
                $donation->donation_date->format('Y-m-d'),
                $donation->status,
                $donation->is_anonymous ? 'Yes' : 'No',
                $donation->notes ?? 'N/A',
                $donation->recorder->name ?? 'Unknown',
                $donation->confirmed_at ? $donation->confirmed_at->format('Y-m-d H:i:s') : 'N/A',
                $donation->created_at->format('Y-m-d H:i:s')
            ]);

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Download all donations as CSV
     */
    public function downloadAllDonations(Request $request)
    {
        $format = $request->get('format', 'csv');

        if ($format === 'pdf') {
            return $this->downloadAllDonationsAsPDF();
        }

        return $this->downloadAllDonationsAsCSV();
    }

    /**
     * Download all donations as CSV
     */
    private function downloadAllDonationsAsCSV()
    {
        $donations = $this->getFilteredDonations();

        $filename = 'all_donations_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($donations) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'ID',
                'Donor Name',
                'Donor Email',
                'Amount',
                'Payment Method',
                'Donation Date',
                'Status',
                'Anonymous',
                'Notes',
                'Recorded By',
                'Confirmed At',
                'Created At'
            ]);

            // CSV Data
            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->id,
                    $donation->is_anonymous ? 'Anonymous' : ($donation->donor_name ?? 'N/A'),
                    $donation->donor_email ?? 'N/A',
                    number_format((float)($donation->amount ?? 0), 2),
                    $donation->payment_method,
                    $donation->donation_date->format('Y-m-d'),
                    $donation->status,
                    $donation->is_anonymous ? 'Yes' : 'No',
                    $donation->notes ?? 'N/A',
                    $donation->recorder->name ?? 'Unknown',
                    $donation->confirmed_at ? $donation->confirmed_at->format('Y-m-d H:i:s') : 'N/A',
                    $donation->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Get filtered donations based on request parameters
     */
    private function getFilteredDonations()
    {
        $query = Donation::with('recorder');

        // Add filters if provided
        if (request()->has('status') && request('status') !== '') {
            $query->where('status', request('status'));
        }

        if (request()->has('payment_method') && request('payment_method') !== '') {
            $query->where('payment_method', request('payment_method'));
        }

        if (request()->has('date_from') && request('date_from') !== '') {
            $query->where('donation_date', '>=', request('date_from'));
        }

        if (request()->has('date_to') && request('date_to') !== '') {
            $query->where('donation_date', '<=', request('date_to'));
        }

        return $query->orderBy('donation_date', 'desc')->get();
    }

    /**
     * Download all donations as PDF
     */
    private function downloadAllDonationsAsPDF()
    {
        try {
            $donations = $this->getFilteredDonations();

            $data = [
                'donations' => $donations,
                'organization' => 'Youmanitarian International',
                'generated_at' => now()->format('F j, Y h:i A'),
                'total_amount' => $donations->sum('amount'),
                'total_count' => $donations->count(),
            ];

            $pdf = Pdf::loadView('finance.pdfs.all_donations', $data);

            $filename = 'all_donations_' . now()->format('Y-m-d_H-i-s') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            // Fallback to CSV if PDF generation fails
            return $this->downloadAllDonationsAsCSV();
        }
    }
}
