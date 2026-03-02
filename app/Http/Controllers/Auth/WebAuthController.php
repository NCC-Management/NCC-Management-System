<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Cadet;

class WebAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN (Session Based Authentication)
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials.',
            ]);
        }

        // Prevent session fixation
        $request->session()->regenerate();

        // Redirect based on role
        return match (Auth::user()->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'cadet'  => redirect()->route('cadet.dashboard'),
            default  => redirect()->route('home'),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER (Public Cadet Enrollment Only)
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        // Create User (Role auto-assigned as cadet)
        $user = User::create([
            'name'     => trim($data['first_name'] . ' ' . $data['last_name']),
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'cadet',
        ]);

        // Create related Cadet record
        Cadet::create([
            'user_id'       => $user->id,
            'enrollment_no' => 'NCC' . random_int(10000, 99999),
        ]);

        // Auto login after successful registration
        Auth::login($user);

        // Regenerate session for safety
        $request->session()->regenerate();

        return redirect()->route('cadet.complete-profile');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}