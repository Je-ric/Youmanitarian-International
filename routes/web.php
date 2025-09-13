<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\HeartReactController;
use App\Http\Controllers\MembershipController;
// use App\Http\Controllers\ContentViewController;
use App\Http\Controllers\ProgramChatController;
use App\Http\Controllers\ProgramTasksController;
use App\Http\Controllers\ContentCommentController;
// use App\Http\Controllers\ContentRequestController;
use App\Http\Controllers\ProgramFeedbackController;
use App\Http\Controllers\ProgramVolunteerController;
use App\Http\Controllers\VolunteerApprovalController;
use App\Http\Controllers\VolunteerAttendanceController;
use App\Http\Controllers\VolunteerApplicationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MembershipReminderController;
use App\Models\MembershipPayment;
use Illuminate\Notifications\DatabaseNotification;
use App\Http\Controllers\ContentReviewCommentController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\ConsultationHourController;
use App\Http\Controllers\ConsultationChatsController;

// =================================================================
// WEBSITE ROUTES (Public - No Authentication Required)
// =================================================================

Route::get('/', [WebsiteController::class, 'index'])->name('website.index');
// Route::get('/news', [WebsiteController::class, 'news'])->name('website.news');
Route::get('/programs', [WebsiteController::class, 'programs'])->name('website.programs');
Route::get('/sponsors', [WebsiteController::class, 'sponsors'])->name('website.sponsors');
Route::get('/about', [WebsiteController::class, 'about'])->name('website.about');
Route::get('/team', [WebsiteController::class, 'team'])->name('website.team');
Route::get('/donate', [WebsiteController::class, 'donate'])->name('website.donate');
Route::get('/weather-forecast', [WebsiteController::class, 'forecast'])->name('weather-forecast.index');
Route::get('/chatbot', [WebsiteController::class, 'chatbot'])->name('chatbot.index');

// Guest feedback (no auth required)
Route::post('/programs/{program}/feedback/guest', [ProgramFeedbackController::class, 'submitGuestFeedback'])
    ->name('programs.feedback.guest.submit');

// Public donation store (no auth)
Route::post('/donations', [DonationController::class, 'store'])
    ->name('website.donations.store')
    ->withoutMiddleware(['auth', 'verified']);


    // Public routes
Route::get('team-members', [TeamMemberController::class, 'index'])->name('content.teamMembers.index');
Route::get('team-members/{team_member}', [TeamMemberController::class, 'show'])->name('content.teamMembers.show');

// Back-compat alias: old name -> redirect to index
Route::get('content/team-members', fn () => redirect()->route('content.teamMembers.index'))->name('content.team-members');

// Admin-only routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('team-members/create', [TeamMemberController::class, 'create'])->name('content.teamMembers.create');
    Route::post('team-members', [TeamMemberController::class, 'store'])->name('content.teamMembers.store');
    Route::get('team-members/{team_member}/edit', [TeamMemberController::class, 'edit'])->name('content.teamMembers.edit');
    Route::put('team-members/{team_member}', [TeamMemberController::class, 'update'])->name('content.teamMembers.update');
    Route::delete('team-members/{team_member}', [TeamMemberController::class, 'destroy'])->name('content.teamMembers.destroy');
});

// =================================================================
// AUTHENTICATION ROUTES
// =================================================================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// =================================================================
// ALL AUTHENTICATED USERS (Common routes for all logged-in users)
// =================================================================

Route::middleware(['auth'])->group(function () {

    // =================================================================
    // DASHBOARD & COMPONENTS
    // =================================================================

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Component Showcase Route
    Route::get('/components/showcase', function () {
        return view('components.showcase');
    })->name('components.showcase');

    // =================================================================
    // NOTIFICATIONS GROUP
    // =================================================================

    Route::get('/notifications/list', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/notifications/{notification}/payment-reminder', [NotificationController::class, 'showPaymentReminder'])->name('notifications.show_payment_reminder');

    // Content reactions
    Route::post('/content/{contentId}/react', [HeartReactController::class, 'toggleReact']);

    // Content comments
    Route::post('/content/{contentId}/comments', [ContentCommentController::class, 'store']);
    Route::put('/content/comments/{commentId}', [ContentCommentController::class, 'update']);
    Route::delete('/content/comments/{commentId}', [ContentCommentController::class, 'destroy']);
    Route::get('/content/{contentId}/comments', [ContentCommentController::class, 'fetchComments']);

    // VOLUNTEER APPLICATION
    Route::get('/volunteers/application-form', [VolunteerApplicationController::class, 'volunteerForm'])->name('volunteers.form');
    Route::post('/volunteers/apply', [VolunteerApplicationController::class, 'store'])->name('volunteer.application.store');

     // Program Chat
     Route::get('/programs/chats/list', [ProgramChatController::class, 'index'])->name('program.chats.index');
     Route::get('/programs/{program}/chats', [ProgramChatController::class, 'show'])->name('program.chats.show');
     Route::post('/programs/{program}/chats', [ProgramChatController::class, 'store'])->name('program.chats.store');
     Route::put('/programs/{program}/chats/{chat}', [ProgramChatController::class, 'update'])->name('program.chats.update');
     Route::delete('/programs/{program}/chats/{chat}', [ProgramChatController::class, 'destroy'])->name('program.chats.destroy');

     //  Route::delete('/programs/{program}/chats/{message}', [ProgramChatController::class, 'destroy'])->name('program.chats.destroy');

    // My Profile (reuse volunteer details view)
    Route::get('/profile/me', [VolunteerController::class, 'myProfile'])->name('profile.me');
    Route::post('/profile/me/photo', [VolunteerController::class, 'updateProfilePhoto'])->name('profile.photo.update');
});



// =================================================================
// PROGRAM COORDINATOR ROUTES
// =================================================================

Route::middleware(['auth', 'role:Program Coordinator'])->group(function () {
// Program CRUD
    Route::get('/programs/list', [ProgramController::class, 'gotoProgramsList'])->name('programs.index');

    Route::get('/programs/create', [ProgramController::class, 'gotoCreateProgram'])->name('programs.create');
    Route::post('/programs/create', [ProgramController::class, 'storeProgram'])->name('programs.store');
    Route::put('/programs/{program}', [ProgramController::class, 'updateProgram'])->name('programs.update');
    // Route::delete('/programs/{program}', [ProgramController::class, 'deleteProgram'])->name('programs.destroy');

    Route::delete('/programs/{program}', [ProgramController::class, 'destroy'])->name('programs.destroy');
    // for component title sa program update
    Route::get('/programs/{program}/component', function (\App\Models\Program $program) {
        return view('programs_volunteers.partials.programDetails', compact('program'))->render();
    })->name('programs.component');


    // Program volunteer management
    Route::get('/programs/{program}/volunteers/manage', [ProgramVolunteerController::class, 'gotoManageVolunteers'])->name('programs.manage_volunteers');
    Route::get('/programs/{program}/volunteers/{volunteer}/logs', [ProgramVolunteerController::class, 'getVolunteerLogs'])->name('programs.volunteer_logs');

    // Program tasks
    Route::get('/programs/{program}/tasks', [ProgramTasksController::class, 'index'])->name('programs.tasks.index');
    Route::post('/programs/{program}/tasks', [ProgramTasksController::class, 'storeTask'])->name('programs.tasks.store');
    Route::delete('/programs/{program}/tasks/{task}', [ProgramTasksController::class, 'deleteTask'])->name('programs.tasks.destroy');
    Route::put('/programs/{program}/tasks/{task}', [ProgramTasksController::class, 'updateTask'])->name('programs.tasks.update');
    Route::put('/programs/{program}/tasks/{task}/assignments/{assignment}/status', [ProgramTasksController::class, 'updateAssignmentStatus'])->name('programs.tasks.assignments.update-status');
    Route::delete('/programs/{program}/tasks/{task}/assignments/{assignment}', [ProgramTasksController::class, 'removeVolunteerFromTask'])->name('programs.tasks.assignments.destroy');
    Route::post('/programs/{program}/tasks/{task}/assign', [ProgramTasksController::class, 'assignVolunteerToTask'])->name('programs.tasks.assign');

    // Attendance management
    Route::get('/programs/{program}/attendance/manual', [VolunteerAttendanceController::class, 'showManualEntryForm'])->name('attendance.manualEntryForm');
    Route::post('/programs/{program}/attendance/manual', [VolunteerAttendanceController::class, 'manualEntry'])->name('attendance.manualEntry');
    Route::post('/programs/attendance/{attendance}/status', [VolunteerAttendanceController::class, 'updateAttendanceStatus'])->name('attendance.status');
    Route::get('/programs/{program}/attendance/volunteers', [VolunteerAttendanceController::class, 'programVolunteers'])->name('programs.volunteers');

    // Volunteer management
    Route::get('/volunteers/list', [VolunteerController::class, 'gotoVolunteersList'])->name('volunteers.index');
    Route::get('/volunteers/{volunteer}/details', [VolunteerController::class, 'gotoVolunteerDetails'])->name('volunteers.volunteer-details');
    Route::post('/volunteers/{id}/approve', [VolunteerApprovalController::class, 'approve'])->name('volunteers.approve');
    Route::post('/volunteers/{id}/deny', [VolunteerApprovalController::class, 'deny'])->name('volunteers.deny');
    Route::post('/volunteers/{id}/restore', [VolunteerApprovalController::class, 'restore'])->name('volunteers.restore');
});

// =================================================================
// VOLUNTEER (All user are Volunteers - not literally)
// =================================================================

Route::middleware(['auth', 'role:Volunteer'])->group(function () {

    // Program viewing (read-only access)
    Route::get('/programs/list', [ProgramController::class, 'gotoProgramsList'])->name('programs.index');
    // Route::get('/programs/create', [ProgramController::class, 'gotoCreateProgram'])->name('programs.create');
    Route::get('/programs/{program}', [ProgramController::class, 'showDetailsModal'])->name('programs.show');

    // Join/leave programs
    Route::post('/programs/{program}/volunteers/join', [ProgramVolunteerController::class, 'joinProgram'])->name('programs.join');
    Route::delete('/programs/{program}/volunteers/{volunteer}/leave', [ProgramVolunteerController::class, 'leaveProgram'])->name('programs.leave');

    // VOLUNTEER ATTENDANCE
    Route::get('/programs/{program}/attendance', [VolunteerAttendanceController::class, 'show'])->name('programs.view');
    Route::post('/programs/{program}/attendance/clock', [VolunteerAttendanceController::class, 'clockInOut'])->name('programs.clock-in-out');
    Route::post('/programs/{program}/attendance/proof', [VolunteerAttendanceController::class, 'uploadProof'])->name('attendance.uploadProof');

    // VOLUNTEER FEEDBACK
    Route::post('/programs/{program}/feedback/volunteer', [ProgramFeedbackController::class, 'submitVolunteerFeedback'])->name('programs.feedback.submit');

    Route::get('/members/invitation/{member}/accept', [MemberController::class, 'acceptInvitation'])
    ->name('member.invitation.accept')
    ->middleware('signed');
    Route::get('/members/invitation/{member}/decline', [MemberController::class, 'declineInvitation'])
    ->name('member.invitation.decline')
    ->middleware('signed');

    Route::resource('consultation-hours', ConsultationHourController::class)->only([
            'index','store','update','destroy','edit'
        ]);

});

// CLEAN, consistent routes (thread view separate from list)
Route::middleware('auth')->group(function () {
    Route::get('/consultation-chats', [ConsultationChatsController::class, 'index'])
        ->name('consultation-chats.index');              // list only (no selected thread)

    Route::get('/consultation-chats/threads/{thread}', [ConsultationChatsController::class, 'show'])
        ->name('consultation-chats.thread.show');        // list + selected thread

    Route::post('/consultation-chats/threads/{thread}/messages', [ConsultationChatsController::class, 'storeMessage'])
        ->name('consultation-chats.thread.message.store');

    Route::get('/consultation-chats/start/{user}', [ConsultationChatsController::class, 'startWithUser'])
        ->name('consultation-chats.start');              // ad‑hoc start (fallback)
});


// =================================================================
// FINANCIAL COORDINATOR (Done - Working Role-Based)
// =================================================================

Route::middleware(['auth', 'role:Financial Coordinator'])->group(function () {

    // Donations
    Route::get('/finance/donations', [DonationController::class, 'index'])->name('finance.index');
    Route::post('/finance/donations', [DonationController::class, 'store'])->name('finance.donations.store');
    Route::patch('/finance/donations/{donation}/status', [DonationController::class, 'updateDonationStatus'])->name('finance.donations.status');
    Route::get('/finance/donations/{donation}/download', [DonationController::class, 'downloadSpecificDonation'])->name('finance.donations.download');
    Route::get('/finance/donations/download/all', [DonationController::class, 'downloadAllDonations'])->name('finance.donations.download.all');

    // Membership payments
    Route::get('/finance/membership/payments', [MembershipController::class, 'index'])->name('finance.membership.payments');
    Route::post('/finance/membership/payments', [MembershipController::class, 'store'])->name('finance.membership.payments.store');
    Route::patch('/finance/membership/payments/{payment}/status', [MembershipController::class, 'updateStatus'])->name('finance.membership.payments.status');

    // Membership payment reminders
    Route::post('/finance/membership/reminders', [MembershipReminderController::class, 'store'])->name('finance.membership.reminders.store');

    // Membership payment modals
    Route::get('/finance/membership/payments/{member}/{quarter}/{year}/modal', [MembershipController::class, 'showAddPaymentModal'])
        ->name('finance.membership.payments.showAddPaymentModal');
    Route::get('/finance/membership/payments/modal/{memberId}/{quarter}/{year}', [MembershipController::class, 'showPaymentModal'])
        ->name('finance.membership.payments.modal');

});

// =================================================================
// ADMINISTRATOR ROUTES (Role management and system administration)
// =================================================================

Route::middleware(['auth', 'role:Admin'])->group(function () {

    Route::get('/roles/list', [RoleController::class, 'gotoRolesList'])->name('roles.index');
    Route::get('/roles/assign', [RoleController::class, 'showAssignForm'])->name('roles.assign.form');
    Route::post('/roles/assign', [RoleController::class, 'assign'])->name('roles.assign');


    Route::get('members/list', [MemberController::class, 'index'])->name('members.index');
    Route::post('/members/create', [MemberController::class, 'store'])->name('members.store');
    Route::patch('/members/{member}/status', [MemberController::class, 'updateStatus'])->name('members.status');
    Route::post('/members/invite/{volunteer}', [MemberController::class, 'invite'])->name('members.invite');
    Route::post('/members/{member}/resend-invitation', [MemberController::class, 'resendInvitation'])->name('members.resend-invitation');
    Route::get('members/invitation/{member}', [MemberController::class, 'showInvitation'])->name('member.invitation.show');

});

// =================================================================
// CONTENT MANAGER ROUTES
// =================================================================

Route::middleware(['auth', 'role:Content Manager'])->group(function () {
    Route::post('/content/{content}/approve', [ContentController::class, 'approveContent'])->name('content.approve');
    Route::post('/content/{content}/needs-revision', [ContentController::class, 'needsRevisionContent'])->name('content.needs_revision');
    Route::post('/content/{content}/reject', [ContentController::class, 'rejectContent'])->name('content.reject');
    Route::post('/content/{content}/archive', [ContentController::class, 'archiveContent'])->name('content.archive');
    Route::get('/content/{content}/review', [ContentController::class, 'review'])->name('content.review');
    Route::post('/content/{content}/unarchive', [ContentController::class, 'unarchive'])->name('content.unarchive');
});

Route::middleware(['auth', 'role:Program Coordinator|Content Manager'])->group(function () {
    Route::get('/content/list', [ContentController::class, 'index'])->name('content.index');
    Route::get('/content/create', [ContentController::class, 'create'])->name('content.create');
    Route::post('/content/store', [ContentController::class, 'store'])->name('content.store');
    Route::get('/content/{content}/edit', [ContentController::class, 'edit'])->name('content.edit');
    Route::put('/content/{content}', [ContentController::class, 'update'])->name('content.update');
    // for deleting individual images, not content
    Route::delete('/content/images/{id}', [ContentController::class, 'destroyImage'])->name('content_images.destroy');
});


Route::post('content-review-comments', [ContentReviewCommentController::class, 'store'])->name('content-review-comments.store');
Route::delete('content-review-comments/{id}', [ContentReviewCommentController::class, 'destroy'])->name('content-review-comments.destroy');

Route::get('/content/{slug}', [WebsiteController::class, 'viewContent'])->name('website.view-content');

