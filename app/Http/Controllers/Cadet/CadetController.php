<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CadetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Complete Profile Page
    |--------------------------------------------------------------------------
    */
    public function completeProfile()
    {
        $user = Auth::user();

        // Allow only cadets
        abort_if($user->role !== 'cadet', 403);

        $cadet = $user->cadet;

        // Safety check
        if (!$cadet) {
            abort(404, 'Cadet record not found.');
        }

        // If profile already completed → redirect to dashboard
        if ($cadet->profile_completed) {
            return redirect()->route('cadet.dashboard');
        }

        return view('cadet.complete-profile', compact('cadet'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store Complete Profile Data
    |--------------------------------------------------------------------------
    */
   public function storeProfile(Request $request)
{
    $user = Auth::user();

    abort_if($user->role !== 'cadet', 403);

    $cadet = $user->cadet;

    if (!$cadet) {
        abort(404, 'Cadet record not found.');
    }

    $data = $request->validate([
        'student_id' => ['required', 'string', 'max:50'],
        'course'     => ['required', 'string', 'max:100'],
        'phone'      => ['required', 'string', 'max:15'],
        'dob'        => ['required', 'date'],
        'gender'     => ['required', 'in:male,female,other'],
        'address'    => ['required', 'string', 'max:500'],
    ]);

    $cadet->update([
        'student_id'        => $data['student_id'],
        'course'            => $data['course'],
        'phone'             => $data['phone'],
        'dob'               => $data['dob'],
        'gender'            => $data['gender'],
        'address'           => $data['address'],
        'profile_completed' => true,
    ]);

    return redirect()->route('cadet.dashboard');
}

    /*
    |--------------------------------------------------------------------------
    | Cadet Dashboard
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $user = Auth::user();

        abort_if($user->role !== 'cadet', 403);

        $cadet = $user->cadet;

        if (!$cadet || !$cadet->profile_completed) {
            return redirect()->route('cadet.complete-profile');
        }

        return view('cadet.dashboard', compact('cadet'));
    }

}

