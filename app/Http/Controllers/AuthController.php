<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cadet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* Show Pages */
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    /* Register */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cadet'
        ]);

        Cadet::create([
            'user_id' => $user->id,
            'enrollment_no' => 'NCC' . rand(10000,99999)
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    /* Login */
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email','password'))) {
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid Credentials']);
    }

    /* Logout */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}