<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\CadetController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CadetController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\AuthController;


/* Front Page */
Route::get('/', function () {
    return view('welcome');
})->name('home');

/* Show Pages */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

/* POST Routes */
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* Dashboard */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

/* Front Page */
Route::get('/', function () {
    return view('welcome');
})->name('home');

/* Auth Pages */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* Dashboard */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');
Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->group(function(){

    Route::get('/dashboard', function(){
        return view('admin.dashboard');
    });

});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/login', [WebAuthController::class, 'login'])->name('login.custom');
Route::post('/register', [WebAuthController::class, 'register'])->name('register.custom');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->group(function(){

    Route::get('/dashboard', [DashboardController::class,'index'])
        ->name('admin.dashboard');

    Route::resource('cadets', CadetController::class);
    Route::resource('units', UnitController::class);
    Route::resource('events', EventController::class);
    Route::resource('attendance', AttendanceController::class);

});

Route::middleware(['auth'])->group(function () {
    Route::get('/cadet/attendance', [AttendanceController::class, 'cadetAttendance'])
        ->name('cadet.attendance');
});


Route::get('/', function () {
    return view('landing');
})->name('home');


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::post('/login', [WebAuthController::class, 'login'])->name('login');
    Route::post('/register', [WebAuthController::class, 'register'])->name('register');

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
    | Admin Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/admin/dashboard', function () {

        abort_if(auth()->user()->role !== 'admin', 403);

        return view('admin.dashboard');

    })->name('admin.dashboard');


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

});

require __DIR__.'/settings.php';