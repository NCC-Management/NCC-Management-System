<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\CadetController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CadetController as AdminCadetController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('cadet.dashboard');
    }
    return view('landing');
})->name('home');


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', function () {
        return view('landing');
    })->name('login');
    
    Route::post('/login', [WebAuthController::class, 'login'])->name('login.post');

    Route::get('/register', function () {
        return view('landing');
    })->name('register');
    
    Route::post('/register', [WebAuthController::class, 'register'])->name('register.post');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Cadet Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('cadet')->group(function () {

        Route::get('/cadet/complete-profile', [CadetController::class, 'completeProfile'])
            ->name('cadet.complete-profile');

        Route::post('/cadet/complete-profile', [CadetController::class, 'storeProfile'])
            ->name('cadet.complete-profile.store');

        Route::get('/cadet/dashboard', [CadetController::class, 'dashboard'])
            ->name('cadet.dashboard');

        Route::get('/cadet/attendance', [AdminAttendanceController::class, 'cadetAttendance'])
            ->name('cadet.attendance');
    });
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
        Route::put('profile/password', [AdminProfileController::class, 'updatePassword'])
            ->name('profile.password.update');
    });

require __DIR__ . '/settings.php';

