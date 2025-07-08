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
use App\Http\Controllers\ContentViewController;
use App\Http\Controllers\ProgramChatController;
use App\Http\Controllers\ProgramTasksController;
use App\Http\Controllers\ContentCommentController;
use App\Http\Controllers\ContentRequestController;
use App\Http\Controllers\ProgramFeedbackController;
use App\Http\Controllers\ProgramVolunteerController;
use App\Http\Controllers\VolunteerApprovalController;
use App\Http\Controllers\VolunteerAttendanceController;
use App\Http\Controllers\VolunteerApplicationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MembershipReminderController;
use App\Models\MembershipPayment;
use Illuminate\Notifications\DatabaseNotification;

// =================================================================
// WEBSITE ROUTES (Public - No Authentication Required)
// =================================================================

Route::get('/', [WebsiteController::class, 'index'])->name('website.index');
Route::get('/content/{slug}', [WebsiteController::class, 'viewContent'])->name('website.view-content');
Route::get('/news', [WebsiteController::class, 'news'])->name('website.news');
Route::get('/programs', [WebsiteController::class, 'programs'])->name('website.programs');
Route::get('/sponsors', [WebsiteController::class, 'sponsors'])->name('website.sponsors');
Route::get('/about', [WebsiteController::class, 'about'])->name('website.about');
Route::get('/team', [WebsiteController::class, 'team'])->name('website.team');
Route::get('/weather-forecast', [WebsiteController::class, 'forecast'])->name('weather-forecast.index');
Route::get('/chatbot', [WebsiteController::class, 'chatbot'])->name('chatbot.index');

// Guest feedback (no auth required)
Route::post('/programs/{program}/feedback/guest', [ProgramFeedbackController::class, 'submitGuestFeedback'])
    ->name('programs.feedback.guest.submit');

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

});


// =================================================================
// CONTENT MANAGER ROUTES
// =================================================================

Route::middleware(['auth', 'role:Content Manager'])->group(function () {

    // Content CRUD
    Route::get('/content/create', [ContentController::class, 'create'])->name('content.create');
    Route::post('/content/store', [ContentController::class, 'store'])->name('content.store');
    Route::get('/content/{content}/edit', [ContentController::class, 'edit'])->name('content.edit');
    Route::put('/content/{content}', [ContentController::class, 'update'])->name('content.update');
    Route::delete('/content/{content}', [ContentController::class, 'destroy'])->name('content.destroy');
    Route::get('/content/list', [ContentController::class, 'content_index'])->name('content.index');
    Route::get('/content/{content}/archive', [ContentController::class, 'archiveContent'])->name('content.archive');

    // Gallery image delete (for deleting individual images, not content)
    Route::delete('/content/images/{id}', [ContentController::class, 'destroyImage'])->name('content_images.destroy');

});

// =================================================================
// VOLUNTEER (All user are Volunteers - not literally)
// =================================================================

Route::middleware(['auth', 'role:Volunteer'])->group(function () {
    
    // VOLUNTEER APPLICATION
    Route::get('/volunteers/application-form', [VolunteerApplicationController::class, 'volunteerForm'])->name('volunteers.form');
    Route::post('/volunteers/apply', [VolunteerApplicationController::class, 'store'])->name('volunteer.application.store');

    // Program viewing (read-only access)
    Route::get('/programs/list', [ProgramController::class, 'gotoProgramsList'])->name('programs.index');
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

});

// =================================================================
// PROGRAM COORDINATOR ROUTES
// =================================================================

Route::middleware(['auth'])->group(function () {

    // Program CRUD 
    Route::get('/programs/list', [ProgramController::class, 'gotoProgramsList'])->name('programs.index');
    
    Route::get('/programs/create', [ProgramController::class, 'gotoCreateProgram'])->name('programs.create');
    Route::post('/programs/create', [ProgramController::class, 'storeProgram'])->name('programs.store');
    Route::put('/programs/{program}', [ProgramController::class, 'updateProgram'])->name('programs.update');
    Route::delete('/programs/{program}', [ProgramController::class, 'deleteProgram'])->name('programs.destroy');

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
    Route::get('/volunteers/{volunteer}/details', [VolunteerController::class, 'gotoVolunteerDetails'])->name('volunteers.viewUser_details');
    Route::post('/volunteers/{id}/approve', [VolunteerApprovalController::class, 'approve'])->name('volunteers.approve');
    Route::post('/volunteers/{id}/deny', [VolunteerApprovalController::class, 'deny'])->name('volunteers.deny');
    Route::post('/volunteers/{id}/restore', [VolunteerApprovalController::class, 'restore'])->name('volunteers.restore');

    // Program Chat
    Route::get('/programs/chats/list', [ProgramChatController::class, 'gotoChatsList'])->name('program.chats.index');
    Route::get('/programs/{program}/chats', [ProgramChatController::class, 'gotoProgramChat'])->name('program.chats.show');
    Route::post('/programs/{program}/chats', [ProgramChatController::class, 'storeChatMessage'])->name('program.chats.store');
    Route::put('/programs/{program}/chats/{chat}', [ProgramChatController::class, 'updateChatMessage'])->name('program.chats.update');
    Route::delete('/programs/{program}/chats/{chat}', [ProgramChatController::class, 'deleteChatMessage'])->name('program.chats.destroy');

});

// =================================================================
// MEMBERSHIP COORDINATOR ROUTES
// =================================================================

Route::middleware(['auth'])->group(function () {

    Route::get('members/list', [MemberController::class, 'index'])->name('members.index');
    Route::post('/members/create', [MemberController::class, 'store'])->name('members.store');
    Route::patch('/members/{member}/status', [MemberController::class, 'updateStatus'])->name('members.status');
    Route::post('/members/invite/{volunteer}', [MemberController::class, 'invite'])->name('members.invite');
    Route::post('/members/{member}/resend-invitation', [MemberController::class, 'resendInvitation'])->name('members.resend-invitation');
    Route::get('members/invitation/{member}', [MemberController::class, 'showInvitation'])->name('member.invitation.show');
    Route::get('/members/invitation/{member}/accept', [MemberController::class, 'acceptInvitation'])
        ->name('member.invitation.accept')
        ->middleware('signed');
    Route::get('/members/invitation/{member}/decline', [MemberController::class, 'declineInvitation'])
        ->name('member.invitation.decline')
        ->middleware('signed');

});

// =================================================================
// FINANCIAL COORDINATOR (Done - Working Role-Based)
// =================================================================

Route::middleware(['auth', 'role:Financial Coordinator'])->group(function () {

    // Donations
    Route::get('/finance/donations', [DonationController::class, 'index'])->name('finance.index');
    Route::post('/finance/donations', [DonationController::class, 'store'])->name('finance.donations.store');
    Route::patch('/finance/donations/{donation}/status', [DonationController::class, 'updateDonationStatus'])->name('finance.donations.status');

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

});