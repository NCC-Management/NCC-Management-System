<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadetController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CadetController as AdminCadetController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\FormController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

/* Home / Landing */
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
    Route::get('/cadet/complete-profile', [CadetController::class, 'completeProfile'])
        ->name('cadet.complete-profile');

    Route::post('/cadet/complete-profile', [CadetController::class, 'storeProfile'])
        ->name('cadet.complete-profile.store');

    Route::get('/cadet/dashboard', [CadetController::class, 'dashboard'])
        ->name('cadet.dashboard');

    // Cadet attendance (uses admin attendance controller method if that's intended)
    Route::get('/cadet/attendance', [AdminAttendanceController::class, 'cadetAttendance'])
        ->name('cadet.attendance');
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

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /*
         |---------------------------------------------------------------------
         | Cadets (admin.cadets.*)
         |---------------------------------------------------------------------
         */
        Route::get('cadets', [AdminCadetController::class, 'index'])->name('cadets.index');
        Route::get('cadets/create', [AdminCadetController::class, 'create'])->name('cadets.create');
        Route::post('cadets', [AdminCadetController::class, 'store'])->name('cadets.store');
        Route::get('cadets/{cadet}', [AdminCadetController::class, 'show'])->name('cadets.show');
        Route::get('cadets/{cadet}/edit', [AdminCadetController::class, 'edit'])->name('cadets.edit');
        Route::put('cadets/{cadet}', [AdminCadetController::class, 'update'])->name('cadets.update');
        Route::patch('cadets/{cadet}', [AdminCadetController::class, 'update']);
        Route::delete('cadets/{cadet}', [AdminCadetController::class, 'destroy'])->name('cadets.destroy');

        /*
         |---------------------------------------------------------------------
         | Units (admin.units.*)
         |---------------------------------------------------------------------
         */
        Route::get('units', [UnitController::class, 'index'])->name('units.index');
        Route::get('units/create', [UnitController::class, 'create'])->name('units.create');
        Route::post('units', [UnitController::class, 'store'])->name('units.store');
        Route::get('units/{unit}', [UnitController::class, 'show'])->name('units.show');
        Route::get('units/{unit}/edit', [UnitController::class, 'edit'])->name('units.edit');
        Route::put('units/{unit}', [UnitController::class, 'update'])->name('units.update');
        Route::patch('units/{unit}', [UnitController::class, 'update']);
        Route::delete('units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');

        /*
         |---------------------------------------------------------------------
         | Events (admin.events.*)
         |---------------------------------------------------------------------
         */
        Route::get('events', [EventController::class, 'index'])->name('events.index');
        Route::get('events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
        Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::patch('events/{event}', [EventController::class, 'update']);
        Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        /*
         |---------------------------------------------------------------------
         | Attendance (admin.attendance.*)
         |---------------------------------------------------------------------
         */
        Route::get('attendance', [AdminAttendanceController::class, 'index'])->name('attendance.index');
        Route::get('attendance/create', [AdminAttendanceController::class, 'create'])->name('attendance.create');
        Route::post('attendance', [AdminAttendanceController::class, 'store'])->name('attendance.store');
        Route::get('attendance/{attendance}', [AdminAttendanceController::class, 'show'])->name('attendance.show');
        Route::get('attendance/{attendance}/edit', [AdminAttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('attendance/{attendance}', [AdminAttendanceController::class, 'update'])->name('attendance.update');
        Route::patch('attendance/{attendance}', [AdminAttendanceController::class, 'update']);
        Route::delete('attendance/{attendance}', [AdminAttendanceController::class, 'destroy'])->name('attendance.destroy');

        /*
         |---------------------------------------------------------------------
         | Forms (admin.forms.*)
         |---------------------------------------------------------------------
         */
        Route::get('forms', [FormController::class, 'index'])->name('forms.index');
        Route::get('forms/approved', [FormController::class, 'approved'])->name('forms.approved');
        Route::get('forms/pending', [FormController::class, 'pending'])->name('forms.pending');
        Route::get('forms/rejected', [FormController::class, 'rejected'])->name('forms.rejected');
        Route::get('forms/create', [FormController::class, 'create'])->name('forms.create');
        Route::post('forms', [FormController::class, 'store'])->name('forms.store');
        Route::get('forms/{form}/edit', [FormController::class, 'edit'])->name('forms.edit');
        Route::put('forms/{form}', [FormController::class, 'update'])->name('forms.update');
        Route::post('forms/{form}/approve', [FormController::class, 'approve'])->name('forms.approve');
        Route::post('forms/{form}/reject', [FormController::class, 'reject'])->name('forms.reject');
        Route::delete('forms/{form}', [FormController::class, 'destroy'])->name('forms.destroy');

    });

require __DIR__ . '/settings.php';