<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Member;
use App\Models\Program;
use App\Models\Donation;
use App\Models\Volunteer;
use App\Models\ProgramTask;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProgramFeedback;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MembershipPayment;
use Illuminate\Support\Facades\DB;
use App\Models\VolunteerAttendance;
use Illuminate\Support\Facades\Response;

class ReportsController extends Controller
{
    // Export a specific program report (details, volunteers+attendance, tasks, feedback)
    public function programReport(Request $request, Program $program)
    {
        $format = $request->get('format', 'csv');

        $program->load(['creator']);
        $volunteers = $program->volunteers()->with('user')->get();
        $attendances = VolunteerAttendance::with(['volunteer.user'])
            ->where('program_id', $program->id)
            ->orderBy('created_at')
            ->get();
        $tasks = ProgramTask::where('program_id', $program->id)
            ->with(['assignments.volunteer.user'])
            ->orderBy('created_at')
            ->get();
        $feedback = ProgramFeedback::with(['volunteer.user'])
            ->where('program_id', $program->id)
            ->orderBy('submitted_at', 'desc')
            ->get();

        if ($format === 'pdf') {
            $filename = 'program_report_' . Str::slug($program->title) . '.pdf';
            $pdf = Pdf::loadView('reports.pdfs.program', [
                'program' => $program,
                'volunteers' => $volunteers,
                'attendances' => $attendances,
                'tasks' => $tasks,
                'feedback' => $feedback,
                'generated_at' => now()->format('F j, Y \a\t g:i A')
            ]);
            return $pdf->download($filename);
        }

        $filename = 'program_report_' . Str::slug($program->title) . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $callback = function () use ($program, $volunteers, $attendances, $tasks, $feedback) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Program Report']);
            fputcsv($out, ['Title', $program->title]);
            fputcsv($out, ['Description', $program->description]);
            fputcsv($out, ['Created By', $program->creator->name ?? 'Unknown']);
            fputcsv($out, ['Date', $program->date]);
            fputcsv($out, ['Start Time', $program->start_time]);
            fputcsv($out, ['End Time', $program->end_time]);
            fputcsv($out, ['Location', $program->location]);
            fputcsv($out, []);

            fputcsv($out, ['Volunteers']);
            fputcsv($out, ['Volunteer ID', 'Name', 'Status']);
            foreach ($volunteers as $v) {
                fputcsv($out, [$v->id, optional($v->user)->name, $v->pivot->status ?? '']);
            }
            fputcsv($out, []);

            fputcsv($out, ['Attendances']);
            fputcsv($out, ['Attendance ID', 'Volunteer', 'Clock In', 'Clock Out', 'Hours', 'Status']);
            foreach ($attendances as $a) {
                fputcsv($out, [
                    $a->id,
                    optional(optional($a->volunteer)->user)->name,
                    $a->clock_in,
                    $a->clock_out,
                    $a->hours_logged,
                    $a->approval_status,
                ]);
            }
            fputcsv($out, []);

            fputcsv($out, ['Tasks']);
            fputcsv($out, ['Task ID', 'Description', 'Status', 'Assignments (volunteer:status)']);
            foreach ($tasks as $t) {
                $assignStr = $t->assignments->map(function ($as) {
                    $name = optional(optional($as->volunteer)->user)->name;
                    return ($name ?: 'Unknown') . ':' . ($as->status ?: '');
                })->implode(' | ');
                fputcsv($out, [$t->id, $t->task_description, $t->status, $assignStr]);
            }
            fputcsv($out, []);

            fputcsv($out, ['Feedback']);
            fputcsv($out, ['ID', 'Volunteer/Guest', 'Rating', 'Feedback', 'Submitted At']);
            foreach ($feedback as $f) {
                $name = $f->user_type === 'guest'
                    ? ($f->guest_name ?: 'Guest')
                    : optional(optional($f->volunteer)->user)->name;
                fputcsv($out, [$f->id, $name, $f->rating, $f->feedback, $f->submitted_at]);
            }

            fclose($out);
        };
        return Response::stream($callback, 200, $headers);
    }

    // Export Users with roles (including users without roles)
    public function usersWithRoles(Request $request)
    {
        $format = $request->get('format', 'csv');
        $users = User::with(['roles', 'volunteer', 'member'])->orderBy('name')->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdfs.users_roles', [
                'users' => $users,
                'generated_at' => now()->format('F j, Y \a\t g:i A')
            ]);
            return $pdf->download('users_with_roles.pdf');
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_with_roles.csv"',
        ];
        $callback = function () use ($users) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['User ID', 'Name', 'Email', 'Roles', 'Volunteer Status', 'Member Type', 'Created At']);
            foreach ($users as $u) {
                $roles = $u->roles->pluck('role_name')->implode(', ');
                $volunteerStatus = $u->volunteer ? $u->volunteer->application_status : 'Not a volunteer';
                $memberType = $u->member ? $u->member->membership_type : 'Not a member';
                fputcsv($out, [
                    $u->id,
                    $u->name,
                    $u->email,
                    $roles ?: 'No roles',
                    $volunteerStatus,
                    $memberType,
                    $u->created_at->format('M j, Y g:i A')
                ]);
            }
            fclose($out);
        };
        return Response::stream($callback, 200, $headers);
    }

    // Export individual user details (admin only)
    public function userDetails(Request $request, User $user)
    {
        $format = $request->get('format', 'pdf');
        $user->load(['roles', 'volunteer.user', 'member.user']);

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdfs.user_details', [
                'user' => $user,
                'generated_at' => now()->format('F j, Y \a\t g:i A')
            ]);
            return $pdf->download('user_details_' . $user->id . '.pdf');
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="user_details_' . $user->id . '.csv"',
        ];
        $callback = function () use ($user) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['User Details']);
            fputcsv($out, ['ID', $user->id]);
            fputcsv($out, ['Name', $user->name]);
            fputcsv($out, ['Email', $user->email]);
            fputcsv($out, ['Created At', $user->created_at->format('M j, Y g:i A')]);
            fputcsv($out, []);

            fputcsv($out, ['Roles']);
            fputcsv($out, ['Role Name']);
            foreach ($user->roles as $role) {
                fputcsv($out, [$role->role_name]);
            }
            fputcsv($out, []);

            if ($user->volunteer) {
                fputcsv($out, ['Volunteer Details']);
                fputcsv($out, ['Application Status', $user->volunteer->application_status]);
                fputcsv($out, ['Total Hours', $user->volunteer->total_hours ?? 0]);
                fputcsv($out, ['Joined At', $user->volunteer->created_at->format('M j, Y g:i A')]);
                fputcsv($out, []);
            }

            if ($user->member) {
                fputcsv($out, ['Member Details']);
                fputcsv($out, ['Membership Type', $user->member->membership_type]);
                fputcsv($out, ['Membership Status', $user->member->membership_status]);
                fputcsv($out, ['Start Date', $user->member->start_date]);
                fputcsv($out, []);
            }

            fclose($out);
        };
        return Response::stream($callback, 200, $headers);
    }

    // Export Members (all, or filtered by type)
    public function members(Request $request)
    {
        $format = $request->get('format', 'csv');
        $type = $request->get('type'); // null|full_pledge|honorary

        if ($format === 'pdf') {
            $query = Member::with('user')->orderBy('start_date', 'desc');
            if (in_array($type, ['full_pledge', 'honorary'])) {
                $query->where('membership_type', $type);
            }
            $members = $query->get();

            $pdf = Pdf::loadView('reports.pdfs.members', [
                'members' => $members,
                'type' => $type,
                'generated_at' => now()->format('F j, Y \a\t g:i A')
            ]);
            $name = 'members' . ($type ? '_' . $type : '') . '.pdf';
            return $pdf->download($name);
        }

        // For CSV, always include both types in one file
        $fullPledgeMembers = Member::with('user')->where('membership_type', 'full_pledge')->orderBy('start_date', 'desc')->get();
        $honoraryMembers = Member::with('user')->where('membership_type', 'honorary')->orderBy('start_date', 'desc')->get();

        $filename = 'all_members.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $callback = function () use ($fullPledgeMembers, $honoraryMembers) {
            $out = fopen('php://output', 'w');

            // Full-pledge members section
            fputcsv($out, ['FULL-PLEDGE MEMBERS']);
            fputcsv($out, ['Member ID', 'Name', 'Email', 'Type', 'Status', 'Start Date', 'Created At']);
            foreach ($fullPledgeMembers as $m) {
                fputcsv($out, [
                    $m->id,
                    optional($m->user)->name ?? 'N/A',
                    optional($m->user)->email ?? 'N/A',
                    $m->membership_type,
                    $m->membership_status,
                    $m->start_date,
                    $m->created_at->format('M j, Y g:i A')
                ]);
            }
            fputcsv($out, []); // Empty row

            // Honorary members section
            fputcsv($out, ['HONORARY MEMBERS']);
            fputcsv($out, ['Member ID', 'Name', 'Email', 'Type', 'Status', 'Start Date', 'Created At']);
            foreach ($honoraryMembers as $m) {
                fputcsv($out, [
                    $m->id,
                    optional($m->user)->name ?? 'N/A',
                    optional($m->user)->email ?? 'N/A',
                    $m->membership_type,
                    $m->membership_status,
                    $m->start_date,
                    $m->created_at->format('M j, Y g:i A')
                ]);
            }

            fclose($out);
        };
        return Response::stream($callback, 200, $headers);
    }

    // Export all volunteers with filtering options
    public function volunteers(Request $request)
    {
        $format = $request->get('format', 'csv');
        $status = $request->get('status'); // approved, denied, pending, or null for all

        $query = Volunteer::with('user');

        if ($status) {
            $query->where('application_status', $status);
        }

        $volunteers = $query->orderBy('created_at', 'desc')->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdfs.volunteers', [
                'volunteers' => $volunteers,
                'status' => $status,
                'generated_at' => now()->format('F j, Y \a\t g:i A')
            ]);
            $filename = 'volunteers' . ($status ? '_' . $status : '') . '_' . now()->format('Y-m-d') . '.pdf';
            return $pdf->download($filename);
        }

        $filename = 'volunteers' . ($status ? '_' . $status : '') . '_' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $callback = function () use ($volunteers) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Volunteer ID', 'Name', 'Email', 'Application Status', 'Total Hours', 'Joined Date']);
            foreach ($volunteers as $v) {
                fputcsv($out, [
                    $v->id,
                    optional($v->user)->name ?? 'N/A',
                    optional($v->user)->email ?? 'N/A',
                    $v->application_status,
                    $v->total_hours ?? 0,
                    $v->created_at->format('Y-m-d')
                ]);
            }
            fclose($out);
        };
        return Response::stream($callback, 200, $headers);
    }

    // Donations: specific and all (moved view to reports/)
    public function donation(Request $request, Donation $donation)
    {
        $format = $request->get('format', 'pdf');
        if ($format === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="donation_' . ($donation->donor_name ?? 'anonymous') . '_' . $donation->donation_date->format('Y-m-d') . '.csv"',
            ];
            $callback = function () use ($donation) {
                $f = fopen('php://output', 'w');
                fputcsv($f, ['ID','Donor Name','Donor Email','Amount','Payment Method','Donation Date','Status','Anonymous','Notes','Recorded By','Confirmed At','Created At','Receipt URL']);
                fputcsv($f, [
                    $donation->id,
                    $donation->is_anonymous ? 'Anonymous' : ($donation->donor_name ?? 'N/A'),
                    $donation->donor_email ?? 'N/A',
                    number_format((float)($donation->amount ?? 0), 2),
                    $donation->payment_method,
                    $donation->donation_date->format('Y-m-d'),
                    $donation->status,
                    $donation->is_anonymous ? 'Yes' : 'No',
                    $donation->notes ?? 'N/A',
                    optional($donation->recorder)->name ?? 'Unknown',
                    $donation->confirmed_at ? $donation->confirmed_at->format('Y-m-d H:i:s') : 'N/A',
                    $donation->created_at->format('Y-m-d H:i:s'),
                    $donation->receipt_url ? url(\Illuminate\Support\Facades\Storage::url($donation->receipt_url)) : 'N/A'
                ]);
                fclose($f);
            };
            return Response::stream($callback, 200, $headers);
        }

        $pdf = Pdf::loadView('reports.pdfs.donation', [
            'donation' => $donation,
            'recorder' => $donation->recorder,
            'organization' => 'Youmanitarian International',
            'generated_at' => now()->format('F j, Y h:i A'),
        ]);
        $filename = 'donation_' . ($donation->donor_name ?? 'anonymous') . '_' . $donation->donation_date->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }

    public function donations(Request $request)
    {
        $format = $request->get('format', 'csv');
        $donations = $this->getFilteredDonations();

        // Calculate summary statistics
        $summary = [
            'total_amount' => $donations->sum('amount'),
            'total_count' => $donations->count(),
            'confirmed' => [
                'count' => $donations->where('status', 'Confirmed')->count(),
                'amount' => $donations->where('status', 'Confirmed')->sum('amount')
            ],
            'pending' => [
                'count' => $donations->where('status', 'Pending')->count(),
                'amount' => $donations->where('status', 'Pending')->sum('amount')
            ],
            'rejected' => [
                'count' => $donations->where('status', 'Rejected')->count(),
                'amount' => $donations->where('status', 'Rejected')->sum('amount')
            ]
        ];

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdfs.donations', [
                'donations' => $donations,
                'summary' => $summary,
                'organization' => 'Youmanitarian International',
                'generated_at' => now()->format('F j, Y \a\t g:i A'),
            ]);
            $filename = 'all_donations_' . now()->format('Y-m-d_H-i-s') . '.pdf';
            return $pdf->download($filename);
        }

        $filename = 'all_donations_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $callback = function () use ($donations, $summary) {
            $file = fopen('php://output', 'w');

            // Summary section
            fputcsv($file, ['DONATION SUMMARY']);
            fputcsv($file, ['Total Donations', $summary['total_count']]);
            fputcsv($file, ['Total Amount', number_format($summary['total_amount'], 2)]);
            fputcsv($file, []);
            fputcsv($file, ['By Status:']);
            fputcsv($file, ['Confirmed', 'Count: ' . $summary['confirmed']['count'], 'Amount: ' . number_format($summary['confirmed']['amount'], 2)]);
            fputcsv($file, ['Pending', 'Count: ' . $summary['pending']['count'], 'Amount: ' . number_format($summary['pending']['amount'], 2)]);
            fputcsv($file, ['Rejected', 'Count: ' . $summary['rejected']['count'], 'Amount: ' . number_format($summary['rejected']['amount'], 2)]);
            fputcsv($file, []);

            // Detailed data
            fputcsv($file, ['DONATION DETAILS']);
            fputcsv($file, ['ID','Donor Name','Donor Email','Amount','Payment Method','Donation Date','Status','Anonymous','Notes','Recorded By','Confirmed At','Created At','Receipt URL']);
            foreach ($donations as $d) {
                fputcsv($file, [
                    $d->id,
                    $d->is_anonymous ? 'Anonymous' : ($d->donor_name ?? 'N/A'),
                    $d->donor_email ?? 'N/A',
                    number_format((float)($d->amount ?? 0), 2),
                    $d->payment_method,
                    $d->donation_date->format('M j, Y'),
                    $d->status,
                    $d->is_anonymous ? 'Yes' : 'No',
                    $d->notes ?? 'N/A',
                    optional($d->recorder)->name ?? 'Unknown',
                    $d->confirmed_at ? $d->confirmed_at->format('M j, Y g:i A') : 'N/A',
                    $d->created_at->format('M j, Y g:i A'),
                    $d->receipt_url ? url(\Illuminate\Support\Facades\Storage::url($d->receipt_url)) : 'N/A'
                ]);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    private function getFilteredDonations()
    {
        $query = Donation::with('recorder');
        if (request()->filled('status')) { $query->where('status', request('status')); }
        if (request()->filled('payment_method')) { $query->where('payment_method', request('payment_method')); }
        if (request()->filled('date_from')) { $query->where('donation_date', '>=', request('date_from')); }
        if (request()->filled('date_to')) { $query->where('donation_date', '<=', request('date_to')); }
        return $query->orderBy('donation_date', 'desc')->get();
    }

    // Membership Payments: specific + all, split by member type (full_pledge/honorary) optional
    public function membershipPayment(Request $request, MembershipPayment $payment)
    {
        $format = $request->get('format', 'pdf');
        $payment->load(['member.user','recorder']);
        if ($format === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="membership_payment_' . $payment->id . '.csv"',
            ];
            $callback = function () use ($payment) {
                $f = fopen('php://output', 'w');
                fputcsv($f, ['ID','Member','Type','Period','Year','Amount','Status','Payment Date','Method','Recorded By','Notes','Created At']);
                fputcsv($f, [
                    $payment->id,
                    optional(optional($payment->member)->user)->name,
                    $payment->member->membership_type ?? 'N/A',
                    $payment->payment_period,
                    $payment->payment_year,
                    number_format((float)($payment->amount ?? 0), 2),
                    $payment->payment_status,
                    $payment->payment_date,
                    $payment->payment_method,
                    optional($payment->recorder)->name ?? 'Unknown',
                    $payment->notes,
                    $payment->created_at->format('Y-m-d H:i:s'),
                ]);
                fclose($f);
            };
            return Response::stream($callback, 200, $headers);
        }

        $pdf = Pdf::loadView('reports.pdfs.membership_payment', [
            'payment' => $payment,
            'generated_at' => now()->format('F j, Y h:i A')
        ]);
        $mpName = 'membership_payment_' . $payment->id . '.pdf';
        return $pdf->download($mpName);
    }

    public function membershipPayments(Request $request)
    {
        $format = $request->get('format', 'csv');
        $type = $request->get('type'); // null|full_pledge|honorary
        $year = $request->get('year');

        $payments = MembershipPayment::with(['member.user','recorder'])
            ->when(in_array($type, ['full_pledge','honorary']), function($q) use ($type) {
                $q->whereHas('member', fn($mq) => $mq->where('membership_type', $type));
            })
            ->when($year, fn($q) => $q->where('payment_year', $year))
            ->orderBy('payment_year','desc')
            ->orderByRaw("FIELD(payment_period,'Q4','Q3','Q2','Q1')")
            ->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdfs.membership_payments', [
                'payments' => $payments,
                'type' => $type,
                'generated_at' => now()->format('F j, Y h:i A')
            ]);
            $name = 'membership_payments' . ($type ? '_' . $type : '') . '.pdf';
            return $pdf->download($name);
        }

        $name = 'membership_payments' . ($type ? '_' . $type : '') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $name . '"',
        ];
        $callback = function () use ($payments) {
            $f = fopen('php://output', 'w');
            fputcsv($f, ['ID','Member','Type','Period','Year','Amount','Status','Payment Date','Method','Recorded By','Notes','Receipt URL']);
            foreach ($payments as $p) {
                fputcsv($f, [
                    $p->id,
                    optional(optional($p->member)->user)->name,
                    optional($p->member)->membership_type,
                    $p->payment_period,
                    $p->payment_year,
                    number_format((float)($p->amount ?? 0), 2),
                    $p->payment_status,
                    $p->payment_date,
                    $p->payment_method,
                    optional($p->recorder)->name,
                    $p->notes,
                    $p->receipt_url ? url(\Illuminate\Support\Facades\Storage::url($p->receipt_url)) : 'N/A'
                ]);
            }
            fclose($f);
        };
        return Response::stream($callback, 200, $headers);
    }
}


