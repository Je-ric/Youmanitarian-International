<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\HeartReactController;
use App\Http\Controllers\ContentViewController;
use App\Http\Controllers\ContentCommentController;
use App\Http\Controllers\ContentRequestController;
use App\Http\Controllers\ProgramVolunteerController;
use App\Http\Controllers\VolunteerAttendanceController;
use App\Http\Controllers\VolunteerApplicationController;

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
    Route::get('/programs-list', [ProgramController::class, 'index'])->name('programs.index'); // View all programs
    Route::get('/programs/create', [ProgramController::class, 'create'])->name('programs.create'); // Form to create
    Route::post('/programs', [ProgramController::class, 'store'])->name('programs.store'); // Save new program
    Route::get('/programs/{program}/edit', [ProgramController::class, 'edit'])->name('programs.edit'); // Edit form
    Route::put('/programs/{program}', [ProgramController::class, 'update'])->name('programs.update'); // Update program
    Route::delete('/programs/{program}', [ProgramController::class, 'destroy'])->name('programs.destroy'); // Delete

    Route::get('/program/{program}', [ProgramController::class, 'showDetailsModal'])->name('programs.show');
});





Route::middleware(['auth'])->group(function () {
    // 
    Route::post('programs/{program}/approve_volunteer/{volunteer}', [ProgramVolunteerController::class, 'approveVolunteer'])->name('programs.approve_volunteer');
    Route::delete('programs/{program}/deny_volunteer/{volunteer}', [ProgramVolunteerController::class, 'denyVolunteer'])->name('programs.deny_volunteer');
    Route::post('/programs/{program}/volunteers/{volunteer}/restore', [ProgramVolunteerController::class, 'restoreVolunteer'])->name('programs.restore_volunteer');
    Route::get('/programs/{program}/volunteers/manage', [ProgramVolunteerController::class, 'manageVolunteers'])->name('programs.manage_volunteers');
    Route::get('/programs/{program}/volunteers/{volunteer}/logs', [ProgramVolunteerController::class, 'getVolunteerLogs'])->name('programs.volunteer_logs');

    //  
    Route::get('/volunteers/{volunteer}/details', [VolunteerController::class, 'showDetails'])->name('volunteers.details');
    Route::get('/volunteers/requests', [VolunteerController::class, 'allVolunteers'])->name('volunteers.requests');
    Route::post('/volunteers/apply', [VolunteerController::class, 'apply'])->name('volunteers.apply');

    // 
    Route::get('/volunteer-form', [VolunteerApplicationController::class, 'volunteerForm'])->name('volunteers.form');
    Route::post('/volunteer-application', [VolunteerApplicationController::class, 'store'])->name('volunteer.application.store');
    Route::post('/program/{program}/apply', [VolunteerApplicationController::class, 'proceedApplication'])->name('programs.proceed_application');
    Route::delete('/program/{program}/cancel', [VolunteerApplicationController::class, 'cancelApplication'])->name('programs.cancel_application');
});


// Volunteer Attendance
Route::middleware(['auth'])->group(function () {
    Route::get('/programs/{program}/view', [VolunteerAttendanceController::class, 'show'])->name('programs.view');
    Route::post('/programs/{program}/clock-in', [VolunteerAttendanceController::class, 'clockIn'])->name('programs.clock-in');
    Route::post('/programs/{program}/clock-out', [VolunteerAttendanceController::class, 'clockOut'])->name('programs.clock-out');
});


