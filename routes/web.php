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
Route::get('/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback']);

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
    Route::delete('/content_images/{id}', [ContentController::class, 'destroyImage'])->name('content_images.destroy');

    // Status Updates for Content Requests
    Route::post('/content/update-status', [ContentViewController::class, 'updateRequestStatus'])->name('content.updateStatus');

    // Archive content
    Route::get('/content/archive/{content}', [ContentViewController::class, 'archiveContent'])->name('content.archive');

    // List
    Route::get('/content', [ContentViewController::class, 'content_index'])->name('content.content_view');
    Route::get('/content-requests', [ContentViewController::class, 'requests_index'])->name('content_requests.requests_view');

    // Content Requests
    Route::get('/content-requests/create', [ContentRequestController::class, 'create'])->name('content_requests.create');
    Route::post('/content-requests/store', [ContentRequestController::class, 'store'])->name('content_requests.store');

    // Create content from request 
    Route::get('/content/create/{contentId?}', [ContentViewController::class, 'create'])->name('content.create');

    Route::post('/react/{contentId}', [HeartReactController::class, 'toggleReact'])->middleware('auth');
});



Route::middleware('auth')->group(function () {
    Route::post('/comments/{contentId}', [ContentCommentController::class, 'store']);
    Route::put('/comments/{commentId}', [ContentCommentController::class, 'update']);
    Route::delete('/comments/{commentId}', [ContentCommentController::class, 'destroy']);
});

Route::get('/comments/{contentId}', [ContentCommentController::class, 'fetchComments']);



// =================================================================

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
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
//                 url                                             class                  direction(action?)
// Remember iba-iba dapat urls same to name

// =================================================================

// Program CRUD
Route::middleware(['auth'])->group(function () {
    Route::get('/programs-list', [ProgramController::class, 'gotoProgramsList'])->name('programs.index'); // View all programs
    Route::get('/programs/create', [ProgramController::class, 'gotoCreateProgram'])->name('programs.create'); // Form to create
    Route::post('/programs', [ProgramController::class, 'storeProgram'])->name('programs.store'); // Save new program
    Route::put('/programs/{program}', [ProgramController::class, 'updateProgram'])->name('programs.update'); // Update program
    Route::delete('/programs/{program}', [ProgramController::class, 'deleteProgram'])->name('programs.destroy'); // Delete
    
    Route::get('/program/{program}', [ProgramController::class, 'showDetailsModal'])->name('programs.show');
});





Route::middleware(['auth'])->group(function () {
    Route::get('/programs/{program}/volunteers/manage', [ProgramVolunteerController::class, 'gotoManageVolunteers'])->name('programs.manage_volunteers');
    Route::get('/programs/{program}/volunteers/{volunteer}/logs', [ProgramVolunteerController::class, 'getVolunteerLogs'])->name('programs.volunteer_logs');

    // Combined volunteer management route
    Route::get('/volunteers', [VolunteerController::class, 'gotoVolunteersList'])->name('volunteers.index');
    Route::get('/volunteers/{volunteer}/details', [VolunteerController::class, 'gotoVolunteerDetails'])->name('volunteers.viewUser_details');

    // Volunteer application routes
    Route::get('/volunteer-form', [VolunteerApplicationController::class, 'volunteerForm'])->name('volunteers.form');
    Route::post('/volunteer-application', [VolunteerApplicationController::class, 'store'])->name('volunteer.application.store');
    Route::post('/programs/{program}/join', [ProgramVolunteerController::class, 'joinProgram'])->name('programs.join');
    Route::delete('/programs/{program}/leave/{volunteer}', [ProgramVolunteerController::class, 'leaveProgram'])->name('programs.leave');
});


// =================== VOLUNTEER ATTENDANCE ===================

Route::middleware(['auth'])->group(function () {
    Route::get('/programs/{program}/view', [VolunteerAttendanceController::class, 'show'])->name('programs.view'); // View attendance page for a program (programs/attendance.blade.php)
    Route::post('/programs/{program}/clock-in-out', [VolunteerAttendanceController::class, 'clockInOut'])->name('programs.clock-in-out');
    Route::post('/programs/{program}/attendance/upload-proof', [VolunteerAttendanceController::class, 'uploadProof'])->name('attendance.uploadProof'); // Upload proof of attendance (modal/form)
    Route::get('/programs/{program}/volunteers', [VolunteerAttendanceController::class, 'programVolunteers'])->name('programs.volunteers'); // List volunteers for a program (programs/volunteers.blade.php)
    Route::post('/attendance/{attendance}/status', [VolunteerAttendanceController::class, 'updateAttendanceStatus'])->name('attendance.status'); // Update attendance status
});

// =================== VOLUNTEER APPLICATION APPROVAL ===================

Route::middleware(['auth'])->group(function () {
    Route::post('/volunteers/{id}/approve', [VolunteerApprovalController::class, 'approve'])->name('volunteers.approve'); // Approve volunteer (action)
    Route::post('/volunteers/{id}/deny', [VolunteerApprovalController::class, 'deny'])->name('volunteers.deny'); // Deny volunteer (action)
    Route::post('/volunteers/{id}/restore', [VolunteerApprovalController::class, 'restore'])->name('volunteers.restore'); // Restore volunteer (action)
});

// =================== PROGRAM FEEDBACK ===================

Route::middleware(['auth'])->group(function () {
    Route::post('/programs/{program}/feedback', [ProgramFeedbackController::class, 'submitVolunteerFeedback'])->name('programs.feedback.submit');  // Submit feedback for a program (modal/form)
});

// Show the manual attendance modal/form
Route::get('/programs/{program}/attendance/manual-entry', [VolunteerAttendanceController::class, 'showManualEntryForm'])->name('attendance.manualEntryForm');

// Handle manual attendance entry submission
Route::post('/programs/{program}/attendance/manual-entry', [VolunteerAttendanceController::class, 'manualEntry'])->name('attendance.manualEntry');

Route::post('/programs/{program}/guest-feedback', [ProgramFeedbackController::class, 'submitGuestFeedback'])
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
    Route::get('/programs/chats', [ProgramChatController::class, 'gotoChatsList'])->name('program.chats.index');
    // Show specific program chat
    Route::get('/programs/{program}/chats', [ProgramChatController::class, 'gotoProgramChat'])->name('program.chats.show');
    Route::post('/programs/{program}/chats', [ProgramChatController::class, 'storeChatMessage'])->name('program.chats.store');
    Route::put('/programs/{program}/chats/{chat}', [ProgramChatController::class, 'updateChatMessage'])->name('program.chats.update');
    Route::delete('/programs/{program}/chats/{chat}', [ProgramChatController::class, 'deleteChatMessage'])->name('program.chats.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Role Management Routes
    Route::get('/roles', [RoleController::class, 'gotoRolesList'])->name('roles.index');
    Route::get('/roles/assign', [RoleController::class, 'showAssignForm'])->name('roles.assign.form');
    Route::post('/roles/assign', [RoleController::class, 'assign'])->name('roles.assign');
});

// Finance Routes
Route::prefix('finance')->group(function () {
    // Finance Dashboard
    Route::get('/', [DonationController::class, 'index'])->name('finance.index');
    
    // Donations Management
    Route::get('/donations', [DonationController::class, 'donations'])->name('finance.donations');
    Route::patch('/donations/{donation}/status', [DonationController::class, 'updateDonationStatus'])->name('finance.donations.status');

    // Membership Payments Management
    Route::get('/membership-payments', [MembershipController::class, 'index'])->name('finance.membership.payments');
    Route::post('/membership-payments', [MembershipController::class, 'store'])->name('finance.membership.payments.store');
    Route::patch('/membership-payments/{payment}/status', [MembershipController::class, 'updateStatus'])->name('finance.membership.payments.status');

    // Member Management
    Route::get('/members', [MemberController::class, 'index'])->name('finance.members');
    Route::post('/members', [MemberController::class, 'store'])->name('finance.members.store');
    Route::patch('/members/{member}/status', [MemberController::class, 'updateStatus'])->name('finance.members.status');
    Route::post('/members/invite/{volunteer}', [MemberController::class, 'invite'])->name('finance.members.invite');
    Route::post('/members/{member}/resend-invitation', [MemberController::class, 'resendInvitation'])->name('finance.members.resend-invitation');
});

// Member invitation routes
Route::middleware(['auth'])->group(function () {
    Route::get('/member/invitation/{member}', [MemberController::class, 'showInvitation'])->name('member.invitation.show');

    Route::get('/member/invitation/{member}/accept', [MemberController::class, 'acceptInvitation'])
        ->name('member.invitation.accept')
        ->middleware('signed');
    
    Route::get('/member/invitation/{member}/decline', [MemberController::class, 'declineInvitation'])
        ->name('member.invitation.decline')
        ->middleware('signed');
});

Route::get('/finance/membership/payments/{member}/{quarter}/{year}/modal', [MembershipController::class, 'showAddPaymentModal'])
    ->name('finance.membership.payments.showAddPaymentModal');

Route::get('/finance/membership/payments/modal/{memberId}/{quarter}/{year}', [MembershipController::class, 'showPaymentModal'])
    ->name('finance.membership.payments.modal');

// Route::get('/donations/export', [DonationController::class, 'export'])->name('donations.export');

// Notification routes
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');