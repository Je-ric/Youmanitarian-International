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
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'pending');
        $search = $request->get('search');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $paymentMethod = $request->get('payment_method');
        $page = $request->get('page', 1);
        $sortBy = $request->get('sort_by', 'donation_date'); // only donation_date | name
        $sortOrder = $request->get('sort_order', 'desc');

        // Build queries for pending and confirmed donations
        $pendingQuery = Donation::where('status', 'Pending');
        $confirmedQuery = Donation::where('status', 'Confirmed');
        $rejectedQuery = Donation::where('status', 'Rejected');

        // Apply search filter
        if ($search) {
            $pendingQuery->where(function($query) use ($search) {
                $query->where('donor_name', 'like', "%{$search}%")
                      ->orWhere('donor_email', 'like', "%{$search}%")
                      ->orWhere('notes', 'like', "%{$search}%");
            });

            $confirmedQuery->where(function($query) use ($search) {
                $query->where('donor_name', 'like', "%{$search}%")
                      ->orWhere('donor_email', 'like', "%{$search}%")
                      ->orWhere('notes', 'like', "%{$search}%");
            });

            $rejectedQuery->where(function($query) use ($search) {
                $query->where('donor_name', 'like', "%{$search}%")
                      ->orWhere('donor_email', 'like', "%{$search}%")
                      ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // Apply date range filter
        if ($dateFrom) {
            $pendingQuery->whereDate('donation_date', '>=', $dateFrom);
            $confirmedQuery->whereDate('donation_date', '>=', $dateFrom);
            $rejectedQuery->whereDate('donation_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $pendingQuery->whereDate('donation_date', '<=', $dateTo);
            $confirmedQuery->whereDate('donation_date', '<=', $dateTo);
            $rejectedQuery->whereDate('donation_date', '<=', $dateTo);
        }

        // Apply payment method filter
        if ($paymentMethod) {
            $pendingQuery->where('payment_method', $paymentMethod);
            $confirmedQuery->where('payment_method', $paymentMethod);
            $rejectedQuery->where('payment_method', $paymentMethod);
        }

        // Apply sorting (only donor_name or donation_date)
        if ($sortBy === 'name') {
            // Handle NULL names last
            $pendingQuery->orderByRaw('donor_name IS NULL')->orderBy('donor_name', $sortOrder);
            $confirmedQuery->orderByRaw('donor_name IS NULL')->orderBy('donor_name', $sortOrder);
            $rejectedQuery->orderByRaw('donor_name IS NULL')->orderBy('donor_name', $sortOrder);
        } else {
            $pendingQuery->orderBy('donation_date', $sortOrder);
            $confirmedQuery->orderBy('donation_date', $sortOrder);
            $rejectedQuery->orderBy('donation_date', $sortOrder);
        }

        // Paginate results
        $pendingDonations = $pendingQuery->paginate(10, ['*'], 'pending_page', $tab === 'pending' ? $page : 1);
        $confirmedDonations = $confirmedQuery->paginate(10, ['*'], 'confirmed_page', $tab === 'confirmed' ? $page : 1);
        $rejectedDonations = $rejectedQuery->paginate(10, ['*'], 'rejected_page', $tab === 'rejected' ? $page : 1);
        // Preserve search parameters in pagination links
        $pendingDonations->appends(['tab' => 'pending', 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo, 'payment_method' => $paymentMethod]);
        $confirmedDonations->appends(['tab' => 'confirmed', 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo, 'payment_method' => $paymentMethod]);
        $rejectedDonations->appends(['tab' => 'rejected', 'search' => $search, 'date_from' => $dateFrom, 'date_to' => $dateTo, 'payment_method' => $paymentMethod]);

        // Calculate totals
        $totalConfirmedDonations = Donation::where('status', 'Confirmed')->sum('amount');
        $confirmedCount = Donation::where('status', 'Confirmed')->count();
        $totalPendingDonations = Donation::where('status', 'Pending')->sum('amount');
        $pendingCount = Donation::where('status', 'Pending')->count();
        // $totalRejectedDonations = Donation::where('status', 'Rejected')->sum('amount');
        // $rejectedCount = Donation::where('status', 'Rejected')->count();

        return view('finance.donations', compact(
            'totalConfirmedDonations',
            'confirmedCount',
            'totalPendingDonations',
            'pendingCount',
            'pendingDonations',
            'confirmedDonations',
            'rejectedDonations',
            'tab',
            'search',
            'dateFrom',
            'dateTo',
            'paymentMethod',
            'sortBy',
            'sortOrder'
        ));
    }

    // finance/donations.blade.php (main)
    public function confirmDonation(Donation $donation)
    {
        // Still undecided kung magdadagdag pa ng status na Decline? Rejected? Cancelled?
        // Ang purpose lang naman kase pag confirm is indicator na talagang nareceived na yung donation.
        // Kaya most probably hindi na need ng iba...
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

    public function rejectDonation(Donation $donation)
    {
        $donation->update([
            'status' => 'Rejected',
            'recorded_by' => Auth::id(),
        ]);

        return redirect()->back()->with('toast', [
            'message' => 'Donation has been rejected.',
            'type' => 'error',
        ]);
    }


    // ╔═══════════════════════════════════════════════════════════════════════╗
    //  Store Donation
    // ╚═══════════════════════════════════════════════════════════════════════╝
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

            if (($validated['donor_email'] ?? null) === 'N/A') {
                $validated['donor_email'] = null;
            }

            // Default donor_name to current user if logged in, not anonymous, and name not provided
            if (empty($validated['donor_name']) && Auth::check() && !$request->boolean('is_anonymous', false)) {
                $validated['donor_name'] = Auth::user()->name;
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
        ]); // Pending status are donations that have been reported/entered not yet verified or received.

        // Redirect based on source route (website vs. dashboard)
        if ($request->routeIs('website.donations.store')) {
            // Optional: return JSON if the website form uses AJAX
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Thank you for your donation.'], 201);
            }

            return redirect()
                ->route('website.donate')
                ->with('toast', [
                    'message' => 'Thank you for your donation! We have received your submission.',
                    'type' => 'success'
                ]);
        }

        // Default: back to finance area (protected)
        return redirect()
            ->route('finance.index')
            ->with('toast', [
                'message' => 'Donation recorded successfully.',
                'type' => 'success'
            ]);
    }


    // ╔═══════════════════════════════════════════════════════════════════════╗
    //  Download specific donation (PDF or CSV)
    // ╚═══════════════════════════════════════════════════════════════════════╝

    public function downloadSpecificDonation(Request $request, Donation $donation)
    {
        $format = $request->get('format', 'pdf'); // default PDF

        if ($format === 'csv') {
            return $this->downloadSpecificDonationAsCSV($donation);
        }
        // if ($format === 'pdf'){}

        return $this->downloadSpecificDonationAsPDF($donation);
    }

    private function downloadSpecificDonationAsPDF(Donation $donation)
    {
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
    }

    private function downloadSpecificDonationAsCSV(Donation $donation)
    {
        $filename = 'donation_' . ($donation->donor_name ?? 'anonymous') . '_' .
            $donation->donation_date->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($donation) {
            $file = fopen('php://output', 'w');

            // Headers
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
                'Created At',
                'Receipt URL'
            ]);

            // Data
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
                $donation->created_at->format('Y-m-d H:i:s'),
                $donation->receipt_url ? url(\Illuminate\Support\Facades\Storage::url($donation->receipt_url)) : 'N/A'
            ]);

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // ╔═══════════════════════════════════════════════════════════════════════╗
    //  Download all donations (PDF or CSV)
    // ╚═══════════════════════════════════════════════════════════════════════╝

    public function downloadAllDonations(Request $request)
    {
        $format = $request->get('format', 'csv'); // default CSV

        if ($format === 'pdf') {
            return $this->downloadAllDonationsAsPDF();
        }

        return $this->downloadAllDonationsAsCSV();
    }

    private function downloadAllDonationsAsPDF()
    {
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
    }

    private function downloadAllDonationsAsCSV()
    {
        $donations = $this->getFilteredDonations();

        $filename = 'all_donations_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($donations) {
            $file = fopen('php://output', 'w');

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

    // ╔═══════════════════════════════════════════════════════════════════════╗
    //  Download all (Filtered)
    // ╚═══════════════════════════════════════════════════════════════════════╝

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
}
