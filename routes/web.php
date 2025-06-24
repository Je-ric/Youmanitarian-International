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

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

// ----------------------------------------------------------------


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// -----------------------------------------------------------------------------

Route::middleware(['auth'])->group(function () {

    // Content CRUD
    Route::get('/content/create', [ContentController::class, 'create'])->name('content.create');
    Route::post('/content/store', [ContentController::class, 'store'])->name('content.store');
    Route::get('/content/{content}/edit', [ContentController::class, 'edit'])->name('content.edit');
    Route::put('/content/{content}', [ContentController::class, 'update'])->name('content.update');

    // Delete content - DELETE route should only be for content deletion
    Route::delete('/content/{content}', [ContentViewController::class, 'destroy'])->name('content.destroy');

    // Gallery image delete (for deleting individual images, not content)
    Route::delete('/content/images/{id}', [ContentController::class, 'destroyImage'])->name('content_images.destroy');

    // Status Updates for Content Requests
    Route::post('/content/status/update', [ContentViewController::class, 'updateRequestStatus'])->name('content.updateStatus');

    // Archive content
    Route::get('/content/{content}/archive', [ContentViewController::class, 'archiveContent'])->name('content.archive');

    // List
    Route::get('/content/list', [ContentViewController::class, 'content_index'])->name('content.content_view');
    Route::get('/content-requests/list', [ContentViewController::class, 'requests_index'])->name('content_requests.requests_view');

    // Content Requests
    Route::get('/content-requests/create', [ContentRequestController::class, 'create'])->name('content_requests.create');
    Route::post('/content-requests/create', [ContentRequestController::class, 'store'])->name('content_requests.store');

    // Create content from request 
    Route::get('/content-requests/{contentId}/convert', [ContentViewController::class, 'create'])->name('content.create');

    Route::post('/content/{contentId}/react', [HeartReactController::class, 'toggleReact']);
});



Route::middleware('auth')->group(function () {
    Route::post('/content/{contentId}/comments', [ContentCommentController::class, 'store']);
    Route::put('/content/comments/{commentId}', [ContentCommentController::class, 'update']);
    Route::delete('/content/comments/{commentId}', [ContentCommentController::class, 'destroy']);
});

Route::get('/content/{contentId}/comments', [ContentCommentController::class, 'fetchComments']);



// =================================================================

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Component Showcase Route
    Route::get('/components/showcase', function () {
        return view('components.showcase');
    })->name('components.showcase');
});

// =================================================================

// Website Routes
Route::get('/', [WebsiteController::class, 'index'])->name('website.index');
Route::get('/content/{id}', [WebsiteController::class, 'viewContent'])->name('website.view-content');
Route::get('/news', [WebsiteController::class, 'news'])->name('website.news');
Route::get('/programs', [WebsiteController::class, 'programs'])->name('website.programs');
Route::get('/sponsors', [WebsiteController::class, 'sponsors'])->name('website.sponsors');
Route::get('/about', [WebsiteController::class, 'about'])->name('website.about');
Route::get('/team', [WebsiteController::class, 'team'])->name('website.team');
Route::get('/weather-forecast', [WebsiteController::class, 'forecast'])->name('weather-forecast.index');
Route::get('/chatbot', [WebsiteController::class, 'chatbot'])->name('chatbot.index');
//                 url                      controller then    class                  direction(action)
// Remember iba-iba dapat urls same to name

// =================================================================

// Program CRUD
Route::middleware(['auth'])->group(function () {
    Route::get('/programs/list', [ProgramController::class, 'gotoProgramsList'])->name('programs.index'); // View all programs
    Route::get('/programs/create', [ProgramController::class, 'gotoCreateProgram'])->name('programs.create'); // Form to create
    Route::post('/programs/create', [ProgramController::class, 'storeProgram'])->name('programs.store'); // Save new program
    Route::put('/programs/{program}', [ProgramController::class, 'updateProgram'])->name('programs.update'); // Update program
    Route::delete('/programs/{program}', [ProgramController::class, 'deleteProgram'])->name('programs.destroy'); // Delete
    
    Route::get('/programs/{program}', [ProgramController::class, 'showDetailsModal'])->name('programs.show');
});





Route::middleware(['auth'])->group(function () {
    Route::get('/programs/{program}/volunteers/manage', [ProgramVolunteerController::class, 'gotoManageVolunteers'])->name('programs.manage_volunteers');
    Route::get('/programs/{program}/volunteers/{volunteer}/logs', [ProgramVolunteerController::class, 'getVolunteerLogs'])->name('programs.volunteer_logs');

    // Combined volunteer management route
    Route::get('/volunteers/list', [VolunteerController::class, 'gotoVolunteersList'])->name('volunteers.index');
    Route::get('/volunteers/{volunteer}/details', [VolunteerController::class, 'gotoVolunteerDetails'])->name('volunteers.viewUser_details');

    // Volunteer application routes
    Route::get('/volunteers/application-form', [VolunteerApplicationController::class, 'volunteerForm'])->name('volunteers.form');
    Route::post('/volunteers/apply', [VolunteerApplicationController::class, 'store'])->name('volunteer.application.store');
    Route::post('/programs/{program}/volunteers/join', [ProgramVolunteerController::class, 'joinProgram'])->name('programs.join');
    Route::delete('/programs/{program}/volunteers/{volunteer}/leave', [ProgramVolunteerController::class, 'leaveProgram'])->name('programs.leave');
});


// =================== VOLUNTEER ATTENDANCE ===================

Route::middleware(['auth'])->group(function () {
    Route::get('/programs/{program}/attendance', [VolunteerAttendanceController::class, 'show'])->name('programs.view'); // View attendance page for a program (programs/attendance.blade.php)
    Route::post('/programs/{program}/attendance/clock', [VolunteerAttendanceController::class, 'clockInOut'])->name('programs.clock-in-out');
    Route::post('/programs/{program}/attendance/proof', [VolunteerAttendanceController::class, 'uploadProof'])->name('attendance.uploadProof'); // Upload proof of attendance (modal/form)
    Route::get('/programs/{program}/attendance/volunteers', [VolunteerAttendanceController::class, 'programVolunteers'])->name('programs.volunteers'); // List volunteers for a program (programs/volunteers.blade.php)
    Route::post('/programs/attendance/{attendance}/status', [VolunteerAttendanceController::class, 'updateAttendanceStatus'])->name('attendance.status'); // Update attendance status
});

// =================== VOLUNTEER APPLICATION APPROVAL ===================

Route::middleware(['auth'])->group(function () {
    Route::post('/volunteers/{id}/approve', [VolunteerApprovalController::class, 'approve'])->name('volunteers.approve'); // Approve volunteer (action)
    Route::post('/volunteers/{id}/deny', [VolunteerApprovalController::class, 'deny'])->name('volunteers.deny'); // Deny volunteer (action)
    Route::post('/volunteers/{id}/restore', [VolunteerApprovalController::class, 'restore'])->name('volunteers.restore'); // Restore volunteer (action)
});

// =================== PROGRAM FEEDBACK ===================

Route::middleware(['auth'])->group(function () {
    Route::post('/programs/{program}/feedback/volunteer', [ProgramFeedbackController::class, 'submitVolunteerFeedback'])->name('programs.feedback.submit');  // Submit feedback for a program (modal/form)
    Route::get('/programs/{program}/attendance/manual', [VolunteerAttendanceController::class, 'showManualEntryForm'])->name('attendance.manualEntryForm');
    Route::post('/programs/{program}/attendance/manual', [VolunteerAttendanceController::class, 'manualEntry'])->name('attendance.manualEntry');

});


Route::post('/programs/{program}/feedback/guest', [ProgramFeedbackController::class, 'submitGuestFeedback'])
    ->name('programs.feedback.guest.submit');

// =================== PROGRAM TASKS ===================

// Program tasks CRUD (programs/tasks/index.blade.php, etc.)
Route::prefix('programs/{program}/tasks')->name('programs.tasks.')->group(function () {
    Route::get('/', [ProgramTasksController::class, 'index'])->name('index'); // List tasks for a program
    Route::post('/', [ProgramTasksController::class, 'storeTask'])->name('store'); 
    Route::delete('{task}', [ProgramTasksController::class, 'deleteTask'])->name('destroy'); 
    Route::put('{task}', [ProgramTasksController::class, 'updateTask'])->name('update');
    Route::put('{task}/assignments/{assignment}/status', [ProgramTasksController::class, 'updateAssignmentStatus'])->name('assignments.update-status');
    Route::delete('{task}/assignments/{assignment}', [ProgramTasksController::class, 'removeVolunteerFromTask'])->name('assignments.destroy');
});
// Assign a volunteer to a task (action)
Route::post('/programs/{program}/tasks/{task}/assign', [ProgramTasksController::class, 'assignVolunteerToTask'])->name('programs.tasks.assign');

// Program Chat Routes
Route::middleware(['auth'])->group(function () {
    // Show all program chats
    Route::get('/programs/chats/list', [ProgramChatController::class, 'gotoChatsList'])->name('program.chats.index');
    // Show specific program chat
    Route::get('/programs/{program}/chats', [ProgramChatController::class, 'gotoProgramChat'])->name('program.chats.show');
    Route::post('/programs/{program}/chats', [ProgramChatController::class, 'storeChatMessage'])->name('program.chats.store');
    Route::put('/programs/{program}/chats/{chat}', [ProgramChatController::class, 'updateChatMessage'])->name('program.chats.update');
    Route::delete('/programs/{program}/chats/{chat}', [ProgramChatController::class, 'deleteChatMessage'])->name('program.chats.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Role Management Routes
    Route::get('/roles/list', [RoleController::class, 'gotoRolesList'])->name('roles.index');
    Route::get('/roles/assign', [RoleController::class, 'showAssignForm'])->name('roles.assign.form');
    Route::post('/roles/assign', [RoleController::class, 'assign'])->name('roles.assign');

    Route::get('/notifications/{notification}/payment-reminder', [NotificationController::class, 'showPaymentReminder'])->name('notifications.show_payment_reminder');
});

// Finance Routes   
Route::middleware(['auth'])->group(function () {
    Route::get('/finance/dashboard', [DonationController::class, 'finance_index'])->name('finance.index');
    Route::get('/finance/donations', [DonationController::class, 'index'])->name('finance.donations');
    
    Route::get('/finance/membership/payments', [MembershipController::class, 'index'])->name('finance.membership.payments');
    Route::post('/finance/membership/payments', [MembershipController::class, 'store'])->name('finance.membership.payments.store');
    Route::patch('/finance/membership/payments/{payment}/status', [MembershipController::class, 'updateStatus'])->name('finance.membership.payments.status');

    // Membership payment reminders
    Route::post('/finance/membership/reminders', [MembershipReminderController::class, 'store'])
        ->name('finance.membership.reminders.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('members/list', [MemberController::class, 'index'])->name('members.index');
    Route::post('/members/create', [MemberController::class, 'store'])->name('members.store');
    Route::patch('/members/{member}/status', [MemberController::class, 'updateStatus'])->name('members.status');
    Route::post('/members/invite/{volunteer}', [MemberController::class, 'invite'])->name('members.invite');
    Route::post('/members/{member}/resend-invitation', [MemberController::class, 'resendInvitation'])->name('members.resend-invitation');
    Route::get('members/invitation/{member}', [MemberController::class, 'showInvitation'])
        ->name('member.invitation.show');

    Route::get('/members/invitation/{member}/accept', [MemberController::class, 'acceptInvitation'])
        ->name('member.invitation.accept')
        ->middleware('signed');
    
    Route::get('/members/invitation/{member}/decline', [MemberController::class, 'declineInvitation'])
        ->name('member.invitation.decline')
        ->middleware('signed');
});

Route::get('/finance/membership/payments/{member}/{quarter}/{year}/modal', [MembershipController::class, 'showAddPaymentModal'])
    ->name('finance.membership.payments.showAddPaymentModal');

Route::get('/finance/membership/payments/modal/{memberId}/{quarter}/{year}', [MembershipController::class, 'showPaymentModal'])
    ->name('finance.membership.payments.modal');

// Route::get('/donations/export', [DonationController::class, 'export'])->name('donations.export');

// Notification routes
Route::get('/notifications/list', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');