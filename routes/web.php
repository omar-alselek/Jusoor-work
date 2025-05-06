<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\CompanyProfileController;
use App\Http\Controllers\Company\JobController;
use App\Http\Controllers\Company\ApplicationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [LoginController::class, 'adminLogin'])->name('admin.login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/companies/{company}/approve', [AdminController::class, 'approveCompany'])->name('companies.approve');
    Route::post('/companies/{company}/reject', [AdminController::class, 'rejectCompany'])->name('companies.reject');
    Route::post('/users/{user}/block', [AdminController::class, 'blockUser'])->name('users.block');
    Route::post('/users/{user}/unblock', [AdminController::class, 'unblockUser'])->name('users.unblock');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Chat routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
});

// Student Routes
Route::middleware(['auth', \App\Http\Middleware\StudentMiddleware::class])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Student\StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\Student\StudentController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [App\Http\Controllers\Student\StudentController::class, 'updateProfile'])->name('profile.update');
    
    Route::get('/opportunities', [App\Http\Controllers\Student\StudentController::class, 'opportunities'])->name('opportunities');
    Route::get('/opportunities/{id}', [App\Http\Controllers\Student\StudentController::class, 'showOpportunity'])->name('opportunities.show');
    Route::post('/opportunities/{id}/apply', [App\Http\Controllers\Student\StudentController::class, 'applyOpportunity'])->name('opportunities.apply');
    
    Route::get('/messages', [App\Http\Controllers\Student\StudentController::class, 'messages'])->name('messages');
    Route::get('/notifications', [App\Http\Controllers\Student\StudentController::class, 'notifications'])->name('notifications');
});

// Public Student Profile
Route::get('/students/{id}', [App\Http\Controllers\Student\StudentController::class, 'showPublicProfile'])->name('student.public_profile');

// Company Routes
Route::middleware(['auth', \App\Http\Middleware\CompanyMiddleware::class])->prefix('company')->name('company.')->group(function () {
    // Waiting approval page
    Route::get('/waiting-approval', function() {
        return view('company.waiting-approval');
    })->name('waiting_approval');

    // Dashboard
    Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('dashboard');

    // Company Profile
    Route::get('/profile/edit', [CompanyProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [CompanyProfileController::class, 'update'])->name('profile.update');
    Route::post('/upload-documents', [CompanyController::class, 'uploadDocuments'])->name('upload_documents');

    // Job Management
    Route::resource('jobs', JobController::class);

    // Application Management
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/applications/{application}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');

    // Messages and Notifications
    Route::get('/messages', function() {
        $users = \App\Models\User::where('id', '!=', auth()->id())->get();
        return view('company.messages', compact('users'));
    })->name('messages');
    Route::get('/notifications', function() {
        return view('company.notifications');
    })->name('notifications');
});

// Job Seeker Routes
Route::middleware(['auth', \App\Http\Middleware\JobSeekerMiddleware::class])->prefix('job-seeker')->name('job_seeker.')->group(function () {
    Route::get('/dashboard', function () {
        return view('job_seeker.dashboard');
    })->name('dashboard');
});

// Test Email Route
Route::get('/test-email', function () {
    \Illuminate\Support\Facades\Mail::to('test@example.com')->send(new \App\Mail\TestEmail());
    return 'Test email sent!';
})->name('test.email');

// Public Company Profile
Route::get('/companies/{id}', [App\Http\Controllers\Company\CompanyProfileController::class, 'showPublicProfile'])->name('company.public_profile');

// Notification routes
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
