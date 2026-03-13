<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Cadet\CadetController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CadetController as AdminCadetController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\LeaveController as AdminLeaveController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('home');


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/portal-login', [WebAuthController::class, 'login'])->name('login.post');
    Route::post('/register', [WebAuthController::class, 'register'])->name('register.post');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'prevent-back-history'])->group(function () {

    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Cadet Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('cadet')->prefix('cadet')->name('cadet.')->group(function () {

        // Profile completion (no approval required yet)
        Route::get('/complete-profile', [CadetController::class, 'completeProfile'])->name('complete-profile');
        Route::post('/complete-profile', [CadetController::class, 'storeProfile'])->name('complete-profile.store');

        // Dashboard (handles pending/rejected/approved view internally)
        Route::get('/dashboard', [CadetController::class, 'dashboard'])->name('dashboard');

        // ── Approved-only routes ──────────────────────────────
        Route::middleware('cadet.approved')->group(function () {
            Route::get('/profile', [CadetController::class, 'profile'])->name('profile');
            Route::put('/profile', [CadetController::class, 'updateProfile'])->name('profile.update');

            Route::get('/attendance', [CadetController::class, 'attendance'])->name('attendance');
            Route::get('/events', [CadetController::class, 'events'])->name('events');
            Route::get('/unit', [CadetController::class, 'unit'])->name('unit');
            Route::get('/training', [CadetController::class, 'training'])->name('training');
            Route::get('/certificates', [CadetController::class, 'certificates'])->name('certificates');

            Route::get('/leave', [CadetController::class, 'leave'])->name('leave');
            Route::post('/leave', [CadetController::class, 'storeLeave'])->name('leave.store');

            Route::get('/notifications', [CadetController::class, 'notifications'])->name('notifications');
        });
    });
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin', 'prevent-back-history'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Cadet management + approvals
        Route::get('cadets/approvals', [AdminCadetController::class, 'pendingApprovals'])->name('cadets.approvals');
        Route::post('cadets/{cadet}/approve', [AdminCadetController::class, 'approve'])->name('cadets.approve');
        Route::post('cadets/{cadet}/reject', [AdminCadetController::class, 'reject'])->name('cadets.reject');
        Route::resource('cadets', AdminCadetController::class);

        Route::resource('units', UnitController::class);
        Route::resource('events', EventController::class);
        Route::resource('attendance', AdminAttendanceController::class);

        Route::get('forms/approved', [FormController::class, 'approved'])->name('forms.approved');
        Route::get('forms/pending', [FormController::class, 'pending'])->name('forms.pending');
        Route::get('forms/rejected', [FormController::class, 'rejected'])->name('forms.rejected');
        Route::resource('forms', FormController::class);

        Route::get('profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');

        // Leave requests
        Route::get('leave', [AdminLeaveController::class, 'index'])->name('leave.index');
        Route::post('leave/{leave}/approve', [AdminLeaveController::class, 'approve'])->name('leave.approve');
        Route::post('leave/{leave}/reject', [AdminLeaveController::class, 'reject'])->name('leave.reject');
    });

require __DIR__ . '/settings.php';
