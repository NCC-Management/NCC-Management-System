<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    return view('landing');
})->name('home');


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


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
        Route::put('profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

require __DIR__ . '/settings.php';