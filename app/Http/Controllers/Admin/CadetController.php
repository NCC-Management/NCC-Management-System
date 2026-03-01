<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Cadet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CadetController extends Controller
{
    public function index()
    {
        $cadets = Cadet::with('user')->get();
        return view('admin.cadets.index', compact('cadets'));
    }

    public function create()
    {
        return view('admin.cadets.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6',
        'enrollment_no' => 'required'
    ]);

    $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Hash::make($request->password),
        'role'=>'cadet'
    ]);

    Cadet::create([
        'user_id'=>$user->id,
        'enrollment_no'=>$request->enrollment_no
    ]);

    return redirect()->route('cadets.index')
        ->with('success','Cadet Created Successfully');
}

    public function edit(Cadet $cadet)
    {
        return view('admin.cadets.edit', compact('cadet'));
    }

    public function update(Request $request, Cadet $cadet)
    {
        $cadet->update($request->all());
        return redirect()->route('cadets.index');
    }

    public function destroy(Cadet $cadet)
    {
        $cadet->delete();
        return back();
    }
}