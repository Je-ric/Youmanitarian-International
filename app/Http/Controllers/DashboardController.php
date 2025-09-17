<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Program;
use App\Models\Content;
use App\Models\Donation;
use App\Models\MembershipPayment;
use App\Models\ProgramFeedback;
use App\Models\HeartReact;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        if ($user->hasRole('Admin')) {
            $data['admin'] = $this->buildAdminData();
        }

        if ($user->hasRole('Content Manager')) {
            $data['cm'] = $this->buildContentManagerData($user);
        }

        if ($user->hasRole('Program Coordinator')) {
            $data['pc'] = $this->buildProgramCoordinatorData($user);
        }

        if ($user->hasRole('Financial Coordinator')) {
            $data['fc'] = $this->buildFinancialCoordinatorData();
        }

        if ($user->hasRole('Volunteer')) {
            $data['volunteer'] = $this->buildVolunteerData($user);
        }

        return view('dashboard', [
            'user' => $user,
            'data' => $data,
        ]);
    }

    private function buildAdminData(): array
    {
        return [
            'usersCount' => User::count(),
            'programsCount' => Program::count(),
            'contentsCount' => Content::count(),
            'donationsTotal' => Donation::where('status', 'Confirmed')->sum('amount'),
            'pendingDonations' => Donation::where('status', 'Pending')->count(),
            'recentDonations' => Donation::latest()->take(5)->get(),
            'topDonationMethods' => Donation::select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
                ->groupBy('payment_method')
                ->orderByDesc('total')
                ->take(5)
                ->get(),
            'pendingContents' => Content::whereIn('approval_status', ['submitted','pending'])
                ->latest('updated_at')->take(5)->get(),
            'topReactedContents' => Content::select('contents.*', DB::raw('(SELECT COUNT(*) FROM heart_reacts WHERE heart_reacts.content_id = contents.id) as hearts'))
                ->orderByDesc('hearts')->take(5)->get(),
        ];
    }

    private function buildContentManagerData($user): array
    {
        $recentPublished = Content::where('content_status', 'published')
            ->latest('published_at')->take(5)
            ->get(['id','title','slug','published_at','created_by']);

        $topReacted = Content::where('content_status', 'published')
            ->leftJoin('heart_reacts as hr', 'hr.content_id', '=', 'contents.id')
            ->select(
                'contents.id',
                'contents.title',
                'contents.slug',
                'contents.image_content',
                'contents.created_by',
                'contents.published_at',
                DB::raw('COUNT(hr.id) as hearts')
            )
            ->groupBy(
                'contents.id',
                'contents.title',
                'contents.slug',
                'contents.image_content',
                'contents.created_by',
                'contents.published_at'
            )
            ->orderByDesc('hearts')->take(5)->get();

        $awaiting = Content::with('user:id,name')
            ->whereIn('approval_status', ['submitted','pending'])
            ->latest('updated_at')->take(5)
            ->get(['id','title','created_by','updated_at']);

        $recentlyUpdated = Content::with('user:id,name')
            ->latest('updated_at')->take(5)
            ->get(['id','title','created_by','updated_at']);

        $from = request('from');
        $to   = request('to');

        // Views over time
        try {
            if (DB::getSchemaBuilder()->hasTable('content_view_logs')) {
                $q = DB::table('content_view_logs')
                    ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as views'));
                if ($from) { $q->whereDate('created_at', '>=', $from); }
                if ($to)   { $q->whereDate('created_at', '<=', $to); }
                if (!$from && !$to) { $q->where('created_at', '>=', now()->subDays(14)); }
                $viewsOverTime = $q->groupBy(DB::raw('DATE(created_at)'))->orderBy('date')->get();
            } else {
                $q = Content::where('content_status', 'published')
                    ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as published_count'));
                if ($from) { $q->whereDate('created_at', '>=', $from); }
                if ($to)   { $q->whereDate('created_at', '<=', $to); }
                if (!$from && !$to) { $q->where('created_at', '>=', now()->subDays(14)); }
                $viewsOverTime = $q->groupBy(DB::raw('DATE(created_at)'))->orderBy('date')->get();
            }
        } catch (\Throwable $e) {
            $viewsOverTime = collect();
        }

        // Reactions over time
        try {
            $rq = HeartReact::query()
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as reacts'));
            if ($from) { $rq->whereDate('created_at', '>=', $from); }
            if ($to)   { $rq->whereDate('created_at', '<=', $to); }
            if (!$from && !$to) { $rq->where('created_at', '>=', now()->subDays(14)); }
            $reactsOverTime = $rq->groupBy(DB::raw('DATE(created_at)'))->orderBy('date')->get();
        } catch (\Throwable $e) {
            $reactsOverTime = collect();
        }

        return [
            'needsApproval'   => Content::whereIn('approval_status', ['submitted', 'pending'])->count(),
            'published'       => Content::where('content_status', 'published')->count(),
            'myDrafts'        => Content::where('created_by', $user->id)->where('content_status', 'draft')->count(),
            'recentPublished' => $recentPublished,
            'topReacted'      => $topReacted,
            'awaiting'        => $awaiting,
            'recentlyUpdated' => $recentlyUpdated,
            'viewsOverTime'   => $viewsOverTime,
            'reactsOverTime'  => $reactsOverTime,
            'range'           => [ 'from' => $from, 'to' => $to ],
        ];
    }

    private function buildProgramCoordinatorData($user): array
    {
        $now = now();
        $myProgramsQuery = Program::where('created_by', $user->id);

        $latestFeedback = ProgramFeedback::with(['volunteer.user','program'])
            ->whereHas('program', fn($q) => $q->where('created_by', $user->id))
            ->latest('submitted_at')->take(5)->get();

        $volunteerStats = [
            'applicationsPending'  => \App\Models\Volunteer::where('application_status','pending')->count(),
            'applicationsApproved' => \App\Models\Volunteer::where('application_status','approved')->count(),
            'applicationsDenied'   => \App\Models\Volunteer::where('application_status','denied')->count(),
        ];

        $engagement = DB::table('program_volunteers')
            ->join('programs','program_volunteers.program_id','=','programs.id')
            ->where('programs.created_by', $user->id)
            ->where('program_volunteers.created_at','>=', now()->subDays(14))
            ->select(DB::raw('DATE(program_volunteers.created_at) as date'), DB::raw('COUNT(*) as joins'))
            ->groupBy(DB::raw('DATE(program_volunteers.created_at)'))
            ->orderBy('date')
            ->get();

        return [
            'myPrograms' => (clone $myProgramsQuery)->count(),
            'ongoing' => (clone $myProgramsQuery)
                ->whereRaw("TIMESTAMP(`date`, `start_time`) <= ?", [$now])
                ->whereRaw("TIMESTAMP(`date`, `end_time`) >= ?", [$now])
                ->count(),
            'upcoming' => (clone $myProgramsQuery)
                ->whereRaw("TIMESTAMP(`date`, `end_time`) > ?", [$now])
                ->count(),
            'latestFeedback' => $latestFeedback,
            'volunteerStats' => $volunteerStats,
            'engagement' => $engagement,
        ];
    }

    private function buildFinancialCoordinatorData(): array
    {
        $topDonationMethods = Donation::select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $recentDonations = Donation::latest()->take(5)->get();

        $currentYear = now()->year;
        $quarters = ['Q1','Q2','Q3','Q4'];
        $quarterly = collect($quarters)->mapWithKeys(function($q) use ($currentYear) {
            $base = MembershipPayment::where('payment_year', $currentYear)->where('payment_period', $q);
            return [$q => [
                'paid_count'    => (clone $base)->where('payment_status','paid')->count(),
                'paid_amount'   => (clone $base)->where('payment_status','paid')->sum('amount'),
                'pending_count' => (clone $base)->where('payment_status','pending')->count(),
                'overdue_count' => (clone $base)->where('payment_status','overdue')->count(),
            ]];
        });

        return [
            'membershipRevenue' => MembershipPayment::where('payment_status', 'paid')->sum('amount'),
            'overduePayments'   => MembershipPayment::where('payment_status', 'overdue')->count(),
            'donationsPending'  => Donation::where('status', 'Pending')->count(),
            'donationsConfirmed'=> Donation::where('status', 'Confirmed')->count(),
            'topDonationMethods'=> $topDonationMethods,
            'recentDonations'   => $recentDonations,
            'quarterly'         => $quarterly,
        ];
    }

    private function buildVolunteerData($user): array
    {
        $volunteer = $user->volunteer;
        $totalHours = $volunteer?->total_hours ?? 0;

        if ($totalHours === 0 && $volunteer) {
            try {
                $totalHours = $volunteer->attendanceLogs()->sum('hours_logged');
            } catch (\Throwable $e) {
                $totalHours = 0;
            }
        }

        $joinedProgramsCount = Program::whereHas('volunteers', function ($q) use ($user) {
            $q->where('volunteers.user_id', $user->id)
              ->where('program_volunteers.status', 'approved');
        })->count();

        $nowTs = now();
        $joinedPrograms = Program::whereHas('volunteers', function ($q) use ($user) {
                $q->where('volunteers.user_id', $user->id)
                  ->where('program_volunteers.status', 'approved');
            })
            ->orderBy('date','desc')
            ->take(15)
            ->get(['id','title','date','start_time','end_time','created_by']);

        $upcoming = $joinedPrograms->filter(function($p) use ($nowTs) {
            return strtotime($p->date.' '.$p->end_time) > $nowTs->timestamp
                && strtotime($p->date.' '.$p->start_time) > $nowTs->timestamp;
        })->values();

        $ongoing = $joinedPrograms->filter(function($p) use ($nowTs) {
            $start = strtotime($p->date.' '.$p->start_time);
            $end   = strtotime($p->date.' '.$p->end_time);
            return $start <= $nowTs->timestamp && $end >= $nowTs->timestamp;
        })->values();

        $done = $joinedPrograms->filter(function($p) use ($nowTs) {
            return strtotime($p->date.' '.$p->end_time) <= $nowTs->timestamp;
        })->values();

        $assignedTasks = 0;
        try {
            if ($volunteer) {
                $assignedTasks = $volunteer->taskAssignments()->count();
            }
        } catch (\Throwable $e) {
            $assignedTasks = 0;
        }

        return [
            'joinedPrograms'  => $joinedProgramsCount,
            'totalHours'      => $totalHours,
            'upcomingPrograms'=> $upcoming,
            'ongoingPrograms' => $ongoing,
            'donePrograms'    => $done,
            'assignedTasks'   => $assignedTasks,
        ];
    }
}
