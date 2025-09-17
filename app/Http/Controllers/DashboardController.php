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
use App\Models\ContentComment;
use App\Models\Bookmark;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        $now = now();

        // Users
        $usersCount   = User::count();
        $usersNew7d   = User::where('created_at', '>=', $now->copy()->subDays(7))->count();
        $users2FAEnabled = 0;
        try {
            if (Schema::hasColumn('users', 'two_factor_confirmed_at')) {
                $users2FAEnabled = User::whereNotNull('two_factor_confirmed_at')->count();
            } elseif (Schema::hasColumn('users', 'two_factor_secret')) {
                $users2FAEnabled = User::whereNotNull('two_factor_secret')->count();
            }
        } catch (\Throwable $e) {
            $users2FAEnabled = 0;
        }

        // Role distribution (supports either user_roles+roles or model_has_roles+roles)
        $roleDistribution = collect();
        try {
            if (Schema::hasTable('user_roles') && Schema::hasTable('roles')) {
                $roleDistribution = DB::table('user_roles')
                    ->join('roles', 'user_roles.role_id', '=', 'roles.id')
                    ->select('roles.name as role', DB::raw('COUNT(*) as count'))
                    ->groupBy('roles.name')
                    ->orderByDesc('count')
                    ->get();
            } elseif (Schema::hasTable('model_has_roles') && Schema::hasTable('roles')) {
                $roleDistribution = DB::table('model_has_roles')
                    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                    ->where('model_type', User::class)
                    ->select('roles.name as role', DB::raw('COUNT(*) as count'))
                    ->groupBy('roles.name')
                    ->orderByDesc('count')
                    ->get();
            }
        } catch (\Throwable $e) {
            $roleDistribution = collect();
        }

        // Programs
        $programsCount = Program::count();
        $ongoingPrograms = Program::whereRaw("TIMESTAMP(`date`, `start_time`) <= ?", [$now])
            ->whereRaw("TIMESTAMP(`date`, `end_time`) >= ?", [$now])
            ->count();
        $upcomingPrograms = Program::whereRaw("TIMESTAMP(`date`, `end_time`) > ?", [$now])->count();
        $completedPrograms = Program::whereRaw("TIMESTAMP(`date`, `end_time`) < ?", [$now])->count();

        // Contents
        $contentsCount     = Content::count();
        $contentsByStatus  = [
            'draft'     => Content::where('content_status', 'draft')->count(),
            'published' => Content::where('content_status', 'published')->count(),
            'archived'  => Content::where('content_status', 'archived')->count(),
        ];
        $pendingApprovals  = Content::whereIn('approval_status', ['submitted','pending'])->count();

        // Donations
        $donationsTotal    = Donation::where('status', 'Confirmed')->sum('amount');
        $pendingDonations  = Donation::where('status', 'Pending')->count();
        $recentDonations   = Donation::latest()->take(5)->get();
        $topDonationMethods = Donation::select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Members
        $membersTotal = 0; $membersNew30d = 0;
        try {
            if (Schema::hasTable('members')) {
                $membersTotal = DB::table('members')->count();
                $membersNew30d = DB::table('members')->where('created_at', '>=', $now->copy()->subDays(30))->count();
            }
        } catch (\Throwable $e) { /* noop */ }

        // Membership payments
        $mpPaidTotal = 0; $mpPendingCount = 0; $mpOverdueCount = 0; $mpBreakdown = collect(); $mpRemindersSent = 0;
        try {
            if (Schema::hasTable('membership_payments')) {
                $mpPaidTotal     = DB::table('membership_payments')->where('payment_status','paid')->sum('amount');
                $mpPendingCount  = DB::table('membership_payments')->where('payment_status','pending')->count();
                $mpOverdueCount  = DB::table('membership_payments')->where('payment_status','overdue')->count();
                // Per-period (month of current year)
                $mpBreakdown = DB::table('membership_payments')
                    ->select(DB::raw('MONTH(payment_date) as month'), DB::raw('SUM(amount) as total'))
                    ->whereYear('payment_date', $now->year)
                    ->where('payment_status','paid')
                    ->groupBy(DB::raw('MONTH(payment_date)'))
                    ->orderBy(DB::raw('MONTH(payment_date)'))
                    ->get();
            }
            if (Schema::hasTable('membership_payments_reminders')) {
                $mpRemindersSent = DB::table('membership_payments_reminders')->count();
            }
        } catch (\Throwable $e) { /* noop */ }

        // Volunteer applications
        $volApps = ['pending' => 0, 'approved' => 0, 'denied' => 0];
        try {
            if (Schema::hasTable('volunteer_application')) {
                foreach (['pending','approved','denied'] as $st) {
                    $volApps[$st] = DB::table('volunteer_application')->where('status', $st)->count();
                }
            }
        } catch (\Throwable $e) { /* noop */ }

        // System queue
        $jobsQueued = 0;
        try { if (Schema::hasTable('jobs')) { $jobsQueued = DB::table('jobs')->count(); } } catch (\Throwable $e) { $jobsQueued = 0; }

        // Team members
        $teamActiveCount = 0;
        try {
            if (Schema::hasTable('team_members')) {
                $teamActiveCount = DB::table('team_members')
                    ->when(Schema::hasColumn('team_members','status'), fn($q) => $q->where('status','active'))
                    ->count();
            }
        } catch (\Throwable $e) { /* noop */ }

        // Consultations
        $consultationThreads = 0; $consultationAvgResponseMin = 0; $nextAvailableSlot = null;
        try {
            if (Schema::hasTable('consultation_threads')) {
                $consultationThreads = DB::table('consultation_threads')->count();
            }
            if (Schema::hasTable('consultation_chats')) {
                // naive avg: difference between first reply and thread created
                $avg = DB::table('consultation_chats as c1')
                    ->join('consultation_threads as t', 'c1.thread_id', '=', 't.id')
                    ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, t.created_at, c1.created_at)) as avg_min'))
                    ->when(Schema::hasColumn('consultation_chats','is_staff'), fn($q) => $q->where('c1.is_staff', 1))
                    ->value('avg_min');
                $consultationAvgResponseMin = (int) round($avg ?? 0);
            }
            if (Schema::hasTable('consultation_hours')) {
                $nextAvailableSlot = DB::table('consultation_hours')
                    ->where(function($q) use ($now){
                        if (Schema::hasColumn('consultation_hours','start_at')) {
                            $q->where('start_at','>=',$now);
                        } elseif (Schema::hasColumn('consultation_hours','available_from')) {
                            $q->where('available_from','>=',$now);
                        }
                    })
                    ->orderByRaw(
                        Schema::hasColumn('consultation_hours','start_at') ? 'start_at' : (Schema::hasColumn('consultation_hours','available_from') ? 'available_from' : 'id')
                    )
                    ->first();
            }
        } catch (\Throwable $e) { /* noop */ }

        return [
            // Users
            'usersCount'           => $usersCount,
            'usersNew7d'           => $usersNew7d,
            'users2FAEnabled'      => $users2FAEnabled,
            'roleDistribution'     => $roleDistribution,
            // Programs
            'programsCount'        => $programsCount,
            'programsOngoing'      => $ongoingPrograms,
            'programsUpcoming'     => $upcomingPrograms,
            'programsCompleted'    => $completedPrograms,
            // Contents
            'contentsCount'        => $contentsCount,
            'contentsByStatus'     => $contentsByStatus,
            'pendingApprovals'     => $pendingApprovals,
            // Donations
            'donationsTotal'       => $donationsTotal,
            'pendingDonations'     => $pendingDonations,
            'recentDonations'      => $recentDonations,
            'topDonationMethods'   => $topDonationMethods,
            // Members
            'membersTotal'         => $membersTotal,
            'membersNew30d'        => $membersNew30d,
            // Membership payments
            'mpPaidTotal'          => $mpPaidTotal,
            'mpPendingCount'       => $mpPendingCount,
            'mpOverdueCount'       => $mpOverdueCount,
            'mpBreakdown'          => $mpBreakdown,
            'mpRemindersSent'      => $mpRemindersSent,
            // Volunteer apps
            'volunteerApplications'=> $volApps,
            // System
            'jobsQueued'           => $jobsQueued,
            'teamActiveCount'      => $teamActiveCount,
            // Consultations
            'consultationThreads'  => $consultationThreads,
            'consultationAvgResponseMin' => $consultationAvgResponseMin,
            'nextConsultationSlot' => $nextAvailableSlot,
            // Admin lists
            'pendingContents' => Content::whereIn('approval_status', ['submitted','pending'])->latest('updated_at')->take(5)->get(),
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

        // Pipeline counts (content_status)
        $countDraft     = Content::where('content_status', 'draft')->count();
        $countPublished = Content::where('content_status', 'published')->count();
        $countArchived  = Content::where('content_status', 'archived')->count();

        // Pipeline counts (approval_status)
        $countSubmitted     = Content::where('approval_status', 'submitted')->count();
        $countPending       = Content::where('approval_status', 'pending')->count();
        $countNeedsRevision = Content::where('approval_status', 'needs_revision')->count();

        // My drafts (count + latest 5)
        $myDraftsCount = Content::where('created_by', $user->id)->where('content_status', 'draft')->count();
        $myDraftsLatest = Content::where('created_by', $user->id)
            ->where('content_status', 'draft')
            ->latest('updated_at')->take(5)
            ->get(['id','title','updated_at']);

        // Comments (last 7d count + latest 5)
        $commentsNew7Count = ContentComment::where('created_at', '>=', now()->subDays(7))->count();
        $commentsLatest = ContentComment::with(['user:id,name', 'content:id,title'])
            ->latest()->take(5)
            ->get(['id','content_id','user_id','comment','created_at']);

        // Bookmarks (totals + top bookmarked posts)
        $bookmarksTotal  = Bookmark::count();
        $bookmarksLast7  = Bookmark::where('created_at', '>=', now()->subDays(7))->count();
        $topBookmarked = Content::leftJoin('bookmarks as bm', 'bm.content_id', '=', 'contents.id')
            ->select(
                'contents.id',
                'contents.title',
                'contents.slug',
                DB::raw('COUNT(bm.id) as bookmarks')
            )
            ->groupBy('contents.id','contents.title','contents.slug')
            ->orderByDesc('bookmarks')
            ->take(5)->get();

        // Review comments (open count + latest 5) via DB fallback
        try {
            $reviewOpenCount = DB::table('content_review_comments')
                ->whereIn('status', ['open','pending','needs_revision'])
                ->count();
        } catch (\Throwable $e) {
            try {
                $reviewOpenCount = DB::table('content_review_comments')->count();
            } catch (\Throwable $e2) {
                $reviewOpenCount = 0;
            }
        }
        try {
            $reviewLatest = DB::table('content_review_comments')
                ->orderByDesc('created_at')->take(5)->get();
        } catch (\Throwable $e) {
            $reviewLatest = collect();
        }

        // Media check (optional)
        $mediaIssues = collect();
        try {
            if (Schema::hasTable('content_images')) {
                $mediaIssues = DB::table('content_images')
                    ->select('content_id', DB::raw('SUM(CASE WHEN (hero_path IS NULL OR hero_path = "") THEN 1 ELSE 0 END) as missing_hero'), DB::raw('SUM(CASE WHEN (image_path IS NULL OR image_path = "" OR image_path LIKE "%://%" = 0) THEN 0 ELSE 0 END) as dummy'))
                    ->groupBy('content_id')
                    ->havingRaw('missing_hero > 0')
                    ->take(10)
                    ->get();
            }
        } catch (\Throwable $e) { $mediaIssues = collect(); }

        return [
            // pipeline (status)
            'countDraft'        => $countDraft,
            'countPublished'    => $countPublished,
            'countArchived'     => $countArchived,
            // pipeline (approval)
            'countSubmitted'    => $countSubmitted,
            'countPending'      => $countPending,
            'countNeedsRevision'=> $countNeedsRevision,
            // existing quick stats
            'needsApproval'     => $countSubmitted + $countPending,
            'published'         => $countPublished,
            'myDrafts'          => $myDraftsCount,

            // lists
            'myDraftsLatest'    => $myDraftsLatest,
            'recentPublished'   => $recentPublished,
            'topReacted'        => $topReacted,
            'awaiting'          => $awaiting,
            'recentlyUpdated'   => $recentlyUpdated,

            // comments & bookmarks
            'commentsNew7Count' => $commentsNew7Count,
            'commentsLatest'    => $commentsLatest,
            'bookmarksTotal'    => $bookmarksTotal,
            'bookmarksLast7'    => $bookmarksLast7,
            'topBookmarked'     => $topBookmarked,

            // review notes
            'reviewOpenCount'   => $reviewOpenCount,
            'reviewLatest'      => $reviewLatest,

            // media check
            'mediaIssues'       => $mediaIssues,

            // charts
            'viewsOverTime'     => $viewsOverTime,
            'reactsOverTime'    => $reactsOverTime,
            'range'             => [ 'from' => $from, 'to' => $to ],
        ];
    }

    private function buildProgramCoordinatorData($user): array
    {
        $now = now();
        $myProgramsQ = Program::where('created_by', $user->id);

        // Program counts
        $myPrograms = (clone $myProgramsQ)->count();
        $ongoing = (clone $myProgramsQ)
            ->whereRaw("TIMESTAMP(`date`, `start_time`) <= ?", [$now])
            ->whereRaw("TIMESTAMP(`date`, `end_time`) >= ?", [$now])
            ->count();
        $upcoming = (clone $myProgramsQ)
            ->whereRaw("TIMESTAMP(`date`, `end_time`) > ?", [$now])
            ->count();
        $completed = (clone $myProgramsQ)
            ->whereRaw("TIMESTAMP(`date`, `end_time`) < ?", [$now])
            ->count();

        // Volunteers approved/pending
        $volCounts = DB::table('program_volunteers')
            ->join('programs','program_volunteers.program_id','=','programs.id')
            ->where('programs.created_by', $user->id)
            ->select('program_volunteers.status', DB::raw('COUNT(*) as cnt'))
            ->groupBy('program_volunteers.status')
            ->pluck('cnt','status');
        $volApproved = (int)($volCounts['approved'] ?? 0);
        $volPending  = (int)($volCounts['pending'] ?? 0);

        // Tasks open/overdue
        $tasksQ = DB::table('program_tasks')
            ->join('programs','program_tasks.program_id','=','programs.id')
            ->where('programs.created_by', $user->id);

        $tasksOpen = (clone $tasksQ)->when(
            Schema::hasColumn('program_tasks','status'),
            fn($q) => $q->whereIn('program_tasks.status', ['open','in_progress']),
            fn($q) => (Schema::hasColumn('program_tasks','completed_at')
                ? $q->whereNull('program_tasks.completed_at')
                : $q)
        )->count();

        $tasksOverdue = DB::table('task_assignments')
            ->join('program_tasks','task_assignments.task_id','=','program_tasks.id')
            ->join('programs','program_tasks.program_id','=','programs.id')
            ->where('programs.created_by', $user->id)
            ->when(Schema::hasColumn('task_assignments','due_date'), fn($q) => $q->where('task_assignments.due_date','<', $now))
            ->when(Schema::hasColumn('task_assignments','status'), fn($q) => $q->where('task_assignments.status','!=','completed'))
            ->count();

        // Attendance: total logs, recent 5, hours last 30d
        $attBase = DB::table('volunteer_attendance')
            ->join('programs','volunteer_attendance.program_id','=','programs.id')
            ->where('programs.created_by', $user->id);

        $attendanceTotalLogs = (clone $attBase)->count();

        // Resolve volunteer name: user_id OR volunteer_id OR program_volunteer_id
        $attRecentQ = (clone $attBase);
        if (Schema::hasColumn('volunteer_attendance', 'user_id')) {
            $attRecentQ->leftJoin('users','volunteer_attendance.user_id','=','users.id');
        } elseif (Schema::hasColumn('volunteer_attendance', 'volunteer_id')) {
            $attRecentQ->leftJoin('volunteers','volunteer_attendance.volunteer_id','=','volunteers.id')
                       ->leftJoin('users','volunteers.user_id','=','users.id');
        } elseif (Schema::hasColumn('volunteer_attendance', 'program_volunteer_id')) {
            $attRecentQ->leftJoin('program_volunteers','volunteer_attendance.program_volunteer_id','=','program_volunteers.id')
                       ->leftJoin('volunteers','program_volunteers.volunteer_id','=','volunteers.id')
                       ->leftJoin('users','volunteers.user_id','=','users.id');
        } elseif (Schema::hasColumn('volunteer_attendance', 'program_volunteers_id')) {
            $attRecentQ->leftJoin('program_volunteers','volunteer_attendance.program_volunteers_id','=','program_volunteers.id')
                       ->leftJoin('volunteers','program_volunteers.volunteer_id','=','volunteers.id')
                       ->leftJoin('users','volunteers.user_id','=','users.id');
        }

        $attendanceRecent = $attRecentQ
            ->select(
                'volunteer_attendance.id',
                'volunteer_attendance.program_id',
                DB::raw('COALESCE(users.name, "Volunteer") as volunteer_name'),
                'volunteer_attendance.created_at',
                DB::raw(
                    Schema::hasColumn('volunteer_attendance','hours_logged')
                        ? 'volunteer_attendance.hours_logged'
                        : (Schema::hasColumn('volunteer_attendance','clock_in') && Schema::hasColumn('volunteer_attendance','clock_out')
                            ? 'TIMESTAMPDIFF(MINUTE, volunteer_attendance.clock_in, volunteer_attendance.clock_out)/60'
                            : 'NULL'
                          ).' as hours_logged'
                )
            )
            ->latest('volunteer_attendance.created_at')
            ->take(5)
            ->get();

        $hours30d = (clone $attBase)->where('volunteer_attendance.created_at','>=', now()->subDays(30));
        if (Schema::hasColumn('volunteer_attendance','hours_logged')) {
            $attendanceHours30d = (clone $hours30d)->sum('volunteer_attendance.hours_logged');
        } elseif (Schema::hasColumn('volunteer_attendance','clock_in') && Schema::hasColumn('volunteer_attendance','clock_out')) {
            $attendanceHours30d = (clone $hours30d)->selectRaw('SUM(TIMESTAMPDIFF(MINUTE, volunteer_attendance.clock_in, volunteer_attendance.clock_out))/60 as hrs')->value('hrs') ?? 0;
        } else {
            $attendanceHours30d = 0;
        }

        // Feedback: avg rating + latest 5
        $avgRating = (float) ProgramFeedback::whereHas('program', fn($q) => $q->where('created_by',$user->id))->avg('rating');
        $latestFeedback = ProgramFeedback::with(['volunteer.user','program'])
            ->whereHas('program', fn($q) => $q->where('created_by', $user->id))
            ->latest('submitted_at')->take(5)->get();

        // Engagement (joins per day)
        $engagement = DB::table('program_volunteers')
            ->join('programs','program_volunteers.program_id','=','programs.id')
            ->where('programs.created_by', $user->id)
            ->where('program_volunteers.created_at','>=', now()->subDays(14))
            ->select(DB::raw('DATE(program_volunteers.created_at) as date'), DB::raw('COUNT(*) as joins'))
            ->groupBy(DB::raw('DATE(program_volunteers.created_at)'))
            ->orderBy('date')
            ->get();

        // Chats: unread + active threads (distinct programs last 7d)
        $chatsUnread = 0;
        if (Schema::hasTable('program_chats')) {
            $chatsUnread = DB::table('program_chats')
                ->join('programs','program_chats.program_id','=','programs.id')
                ->where('programs.created_by', $user->id)
                ->when(Schema::hasColumn('program_chats','is_read'), fn($q) => $q->where('program_chats.is_read', 0))
                ->count();
        }
        $chatsActive = DB::table('program_chats')
            ->join('programs','program_chats.program_id','=','programs.id')
            ->where('programs.created_by', $user->id)
            ->where('program_chats.created_at','>=', now()->subDays(7))
            ->distinct('program_chats.program_id')
            ->count('program_chats.program_id');

        // Requests: latest 3 (status + program_id optional)
$prog_req = DB::table('program_requests');

$reqSelect = [
    'program_requests.id',
    'program_requests.created_at',
];

// Dynamically add program_id if it exists
if (Schema::hasColumn('program_requests', 'program_id')) {
    $reqSelect[] = 'program_requests.program_id';
}

// Dynamically add status column if it exists
$statusCol = null;
foreach (['status', 'request_status', 'approval_status', 'state'] as $col) {
    if (Schema::hasColumn('program_requests', $col)) {
        $statusCol = $col;
        break;
    }
}

if ($statusCol) {
    $reqSelect[] = DB::raw("program_requests.$statusCol as status");
} else {
    $reqSelect[] = DB::raw('NULL as status');
}

$requestsLatest = $prog_req
    ->select($reqSelect)
    ->latest('program_requests.created_at')
    ->take(3)
    ->get();

        // Requests pending count (if status column exists)
        $requestsPending = 0;
        try {
            if ($statusCol) {
                $requestsPending = DB::table('program_requests')
                    ->when(Schema::hasColumn('program_requests','program_id'), fn($q) => $q->join('programs','program_requests.program_id','=','programs.id')->where('programs.created_by',$user->id))
                    ->where("program_requests.$statusCol", 'pending')
                    ->count();
            }
        } catch (\Throwable $e) { $requestsPending = 0; }

        return [
            'myPrograms'         => $myPrograms,
            'ongoing'            => $ongoing,
            'upcoming'           => $upcoming,
            'completed'          => $completed,

            'volApproved'        => $volApproved,
            'volPending'         => $volPending,

            'tasksOpen'          => $tasksOpen,
            'tasksOverdue'       => $tasksOverdue,

            'attendanceTotalLogs'=> $attendanceTotalLogs,
            'attendanceRecent'   => $attendanceRecent,
            'attendanceHours30d' => round($attendanceHours30d, 2),

            'avgRating'          => round($avgRating, 2),
            'latestFeedback'     => $latestFeedback,

            'engagement'         => $engagement,

            'chatsUnread'        => $chatsUnread,
            'chatsActive'        => $chatsActive,

            'requestsLatest'     => $requestsLatest,
            'requestsPending'    => $requestsPending,
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

        // Members metrics for FC
        $membersActive = 0; $membersGrowth30d = 0;
        try {
            if (Schema::hasTable('members')) {
                $membersActive = DB::table('members')
                    ->when(Schema::hasColumn('members','status'), fn($q) => $q->where('status','active'))
                    ->count();
                $membersGrowth30d = DB::table('members')->where('created_at','>=', now()->subDays(30))->count();
            }
        } catch (\Throwable $e) { /* noop */ }

        // Reminders metrics
        $remindersSent = 0; $remindersUpcoming7d = 0; $remindersDue = 0;
        try {
            if (Schema::hasTable('membership_payments_reminders')) {
                $remindersSent = DB::table('membership_payments_reminders')->count();
                if (Schema::hasColumn('membership_payments_reminders','scheduled_at')) {
                    $remindersUpcoming7d = DB::table('membership_payments_reminders')
                        ->whereBetween('scheduled_at', [now(), now()->addDays(7)])
                        ->count();
                }
            }
            if (Schema::hasTable('membership_payments')) {
                $remindersDue = DB::table('membership_payments')->where('payment_status','pending')->count();
            }
        } catch (\Throwable $e) { /* noop */ }

        // Trends
        $donationsPerWeek = collect();
        $mpPerMonth = collect();
        try {
            $donationsPerWeek = Donation::select(DB::raw('YEARWEEK(donation_date, 1) as yw'), DB::raw('SUM(CASE WHEN status = "Confirmed" THEN amount ELSE 0 END) as total'))
                ->where('donation_date','>=', now()->subWeeks(8))
                ->groupBy(DB::raw('YEARWEEK(donation_date, 1)'))
                ->orderBy(DB::raw('YEARWEEK(donation_date, 1)'))
                ->get();
        } catch (\Throwable $e) { $donationsPerWeek = collect(); }
        try {
            if (Schema::hasTable('membership_payments')) {
                $mpPerMonth = DB::table('membership_payments')
                    ->select(DB::raw('MONTH(payment_date) as month'), DB::raw('SUM(CASE WHEN payment_status = "paid" THEN amount ELSE 0 END) as total'))
                    ->whereYear('payment_date', now()->year)
                    ->groupBy(DB::raw('MONTH(payment_date)'))
                    ->orderBy(DB::raw('MONTH(payment_date)'))
                    ->get();
            }
        } catch (\Throwable $e) { $mpPerMonth = collect(); }

        return [
            'membershipRevenue' => MembershipPayment::where('payment_status', 'paid')->sum('amount'),
            'overduePayments'   => MembershipPayment::where('payment_status', 'overdue')->count(),
            'donationsPending'  => Donation::where('status', 'Pending')->count(),
            'donationsConfirmed'=> Donation::where('status', 'Confirmed')->count(),
            'topDonationMethods'=> $topDonationMethods,
            'recentDonations'   => $recentDonations,
            'quarterly'         => $quarterly,
            // extra
            'membersActive'     => $membersActive,
            'membersGrowth30d'  => $membersGrowth30d,
            'remindersSent'     => $remindersSent,
            'remindersUpcoming7d'=> $remindersUpcoming7d,
            'remindersDue'      => $remindersDue,
            'donationsPerWeek'  => $donationsPerWeek,
            'mpPerMonth'        => $mpPerMonth,
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
        $nextDueTask = null;
        try {
            if ($volunteer) {
                $assignedTasks = $volunteer->taskAssignments()->count();
                $nextDueTask = $volunteer->taskAssignments()
                    ->when(Schema::hasColumn('task_assignments','status'), fn($q) => $q->where('status','!=','completed'))
                    ->when(Schema::hasColumn('task_assignments','due_date'), fn($q) => $q->orderBy('due_date'))
                    ->first();
            }
        } catch (\Throwable $e) {
            $assignedTasks = 0;
        }

        // Application status
        $applicationStatus = null;
        try {
            if (Schema::hasTable('volunteer_application')) {
                $applicationStatus = DB::table('volunteer_application')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->value('status');
            }
        } catch (\Throwable $e) { $applicationStatus = null; }

        // Feedback given
        $feedbackGivenCount = 0; $feedbackLastSubmitted = null;
        try {
            $feedbackGivenCount = ProgramFeedback::where('volunteer_id', optional($volunteer)->id)->count();
            $feedbackLastSubmitted = ProgramFeedback::where('volunteer_id', optional($volunteer)->id)->latest('submitted_at')->value('submitted_at');
        } catch (\Throwable $e) { /* noop */ }

        // Program chats unread for volunteer (if table exists and column is_read)
        $volChatsUnread = 0;
        try {
            if (Schema::hasTable('program_chats')) {
                $volChatsUnread = DB::table('program_chats')
                    ->when(Schema::hasColumn('program_chats','user_id'), fn($q) => $q->where('user_id', $user->id))
                    ->when(Schema::hasColumn('program_chats','is_read'), fn($q) => $q->where('is_read', 0))
                    ->count();
            }
        } catch (\Throwable $e) { $volChatsUnread = 0; }

        return [
            'joinedPrograms'  => $joinedProgramsCount,
            'totalHours'      => $totalHours,
            'upcomingPrograms'=> $upcoming,
            'ongoingPrograms' => $ongoing,
            'donePrograms'    => $done,
            'assignedTasks'   => $assignedTasks,
            'nextDueTask'     => $nextDueTask,
            'applicationStatus'=> $applicationStatus,
            'feedbackGivenCount'=> $feedbackGivenCount,
            'feedbackLastSubmitted'=> $feedbackLastSubmitted,
            'chatsUnread'     => $volChatsUnread,
        ];
    }
}
