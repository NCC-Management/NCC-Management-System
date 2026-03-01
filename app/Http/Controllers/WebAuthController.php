<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cadet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebAuthController extends Controller
{
    // REGISTER
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
            'enrollment_no' => 'NCC'.rand(10000,99999)
        ]);

        Auth::login($user);

        return redirect('/admin/dashboard');
    }

    // LOGIN
    public function login(Request $request)
    {
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {

            if(auth()->user()->role == 'admin'){
                return redirect('/admin/dashboard');
            }

            return redirect('/dashboard');
        }

        return back()->withErrors(['email'=>'Invalid credentials']);
    }

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}