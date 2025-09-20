<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Program;
use App\Models\Volunteer;
use App\Models\VolunteerAttendance;
use App\Models\ProgramTask;
use App\Models\ProgramFeedback;
use App\Models\User;
use App\Models\Role;
use App\Models\Member;
use App\Models\Donation;
use App\Models\MembershipPayment;

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
            $pdf = Pdf::loadView('reports.pdfs.program', [
                'program' => $program,
                'volunteers' => $volunteers,
                'attendances' => $attendances,
                'tasks' => $tasks,
                'feedback' => $feedback,
                'generated_at' => now()->format('F j, Y h:i A')
            ]);
            $filename = 'program_report_' . $program->id . '.pdf';
            return $pdf->download($filename);
        }

        $filename = 'program_report_' . $program->id . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $callback = function () use ($program, $volunteers, $attendances, $tasks, $feedback) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Program Report']);
            fputcsv($out, ['Title', $program->title]);
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
        $users = User::with('roles')->orderBy('name')->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdfs.users_roles', [
                'users' => $users,
                'generated_at' => now()->format('F j, Y h:i A')
            ]);
            return $pdf->download('users_with_roles.pdf');
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users_with_roles.csv"',
        ];
        $callback = function () use ($users) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['User ID', 'Name', 'Email', 'Roles']);
            foreach ($users as $u) {
                $roles = $u->roles->pluck('role_name')->implode(', ');
                fputcsv($out, [$u->id, $u->name, $u->email, $roles ?: 'No roles']);
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
        $query = Member::with('user')->orderBy('start_date', 'desc');
        if (in_array($type, ['full_pledge', 'honorary'])) {
            $query->where('membership_type', $type);
        }
        $members = $query->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdfs.members', [
                'members' => $members,
                'type' => $type,
                'generated_at' => now()->format('F j, Y h:i A')
            ]);
            $name = 'members' . ($type ? '_' . $type : '') . '.pdf';
            return $pdf->download($name);
        }

        $filename = 'members' . ($type ? '_' . $type : '') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $callback = function () use ($members) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Member ID', 'Name', 'Type', 'Status', 'Start Date']);
            foreach ($members as $m) {
                fputcsv($out, [$m->id, optional($m->user)->name, $m->membership_type, $m->membership_status, $m->start_date]);
            }
            fclose($out);
        };
        return Response::stream($callback, 200, $headers);
    }

    // Export Volunteer details (specific) or all
    public function volunteers(Request $request, Volunteer $volunteer = null)
    {
        $format = $request->get('format', 'csv');
        if ($volunteer) {
            $volunteer->load(['user', 'programs', 'attendanceLogs.program', 'member', 'application']);
            if ($format === 'pdf') {
                $pdf = Pdf::loadView('reports.pdfs.volunteer', [
                    'volunteer' => $volunteer,
                    'generated_at' => now()->format('F j, Y h:i A')
                ]);
                $name = 'volunteer_' . $volunteer->id . '.pdf';
                return $pdf->download($name);
            }
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="volunteer_' . $volunteer->id . '.csv"',
            ];
            $callback = function () use ($volunteer) {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['Volunteer Detail']);
                fputcsv($out, ['Name', optional($volunteer->user)->name]);
                fputcsv($out, ['Application Status', $volunteer->application_status]);
                fputcsv($out, ['Joined At', $volunteer->joined_at]);
                fputcsv($out, []);
                fputcsv($out, ['Programs']);
                fputcsv($out, ['Program ID', 'Title']);
                foreach ($volunteer->programs as $p) { fputcsv($out, [$p->id, $p->title]); }
                fputcsv($out, []);
                fputcsv($out, ['Attendance Logs']);
                fputcsv($out, ['Program', 'Clock In', 'Clock Out', 'Hours', 'Status']);
                foreach ($volunteer->attendanceLogs as $log) {
                    fputcsv($out, [optional($log->program)->title, $log->clock_in, $log->clock_out, $log->hours_logged, $log->approval_status]);
                }
                fclose($out);
            };
            return Response::stream($callback, 200, $headers);
        }

        $vols = Volunteer::with('user')->orderBy('created_at', 'desc')->get();
        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdfs.volunteers', [
                'volunteers' => $vols,
                'generated_at' => now()->format('F j, Y h:i A')
            ]);
            return $pdf->download('volunteers.pdf');
        }
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="volunteers.csv"',
        ];
        $callback = function () use ($vols) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Volunteer ID', 'Name', 'Application Status', 'Joined At']);
            foreach ($vols as $v) {
                fputcsv($out, [$v->id, optional($v->user)->name, $v->application_status, $v->joined_at]);
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

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('reports.pdfs.donations', [
                'donations' => $donations,
                'organization' => 'Youmanitarian International',
                'generated_at' => now()->format('F j, Y h:i A'),
                'total_amount' => $donations->sum('amount'),
                'total_count' => $donations->count(),
            ]);
            $filename = 'all_donations_' . now()->format('Y-m-d_H-i-s') . '.pdf';
            return $pdf->download($filename);
        }

        $filename = 'all_donations_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $callback = function () use ($donations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID','Donor Name','Donor Email','Amount','Payment Method','Donation Date','Status','Anonymous','Notes','Recorded By','Confirmed At','Created At']);
            foreach ($donations as $d) {
                fputcsv($file, [
                    $d->id,
                    $d->is_anonymous ? 'Anonymous' : ($d->donor_name ?? 'N/A'),
                    $d->donor_email ?? 'N/A',
                    number_format((float)($d->amount ?? 0), 2),
                    $d->payment_method,
                    $d->donation_date->format('Y-m-d'),
                    $d->status,
                    $d->is_anonymous ? 'Yes' : 'No',
                    $d->notes ?? 'N/A',
                    optional($d->recorder)->name ?? 'Unknown',
                    $d->confirmed_at ? $d->confirmed_at->format('Y-m-d H:i:s') : 'N/A',
                    $d->created_at->format('Y-m-d H:i:s'),
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
            fputcsv($f, ['ID','Member','Type','Period','Year','Amount','Status','Payment Date','Method','Recorded By','Notes']);
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
                ]);
            }
            fclose($f);
        };
        return Response::stream($callback, 200, $headers);
    }
}


