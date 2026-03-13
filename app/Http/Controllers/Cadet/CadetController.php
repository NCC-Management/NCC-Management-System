<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\CadetNotification;
use App\Models\Event;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CadetController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Complete Profile Page
    |--------------------------------------------------------------------------
    */
    public function completeProfile()
    {
        $user  = Auth::user();
        abort_if($user->role !== 'cadet', 403);

        $cadet = $user->cadet;
        if (!$cadet) abort(404, 'Cadet record not found.');

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
        $user  = Auth::user();
        abort_if($user->role !== 'cadet', 403);

        $cadet = $user->cadet;
        if (!$cadet) abort(404, 'Cadet record not found.');

        $data = $request->validate([
            'student_id' => ['required', 'string', 'max:50'],
            'course'     => ['required', 'string', 'max:100'],
            'phone'      => ['required', 'string', 'max:15'],
            'dob'        => ['required', 'date'],
            'gender'     => ['required', 'in:male,female,other'],
            'address'    => ['required', 'string', 'max:500'],
        ]);

        $cadet->update(array_merge($data, ['profile_completed' => true]));

        return redirect()->route('cadet.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | Cadet Dashboard (shows pending / rejected / approved states)
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $user  = Auth::user();
        abort_if($user->role !== 'cadet', 403);

        $cadet = $user->cadet;
        if (!$cadet) abort(404);

        // If profile not done yet redirect there
        if (!$cadet->profile_completed) {
            return redirect()->route('cadet.complete-profile');
        }

        // Build stats for approved cadet dashboard
        $stats = [];
        if ($cadet->isApproved()) {
            $cadet->load(['unit', 'attendances.event']);

            $totalEvents    = Event::count();
            $attended       = $cadet->attendances()->where('status', 'present')->count();
            $attendancePct  = $cadet->attendancePercentage();
            $upcomingEvents = Event::where('event_date', '>=', now()->toDateString())
                                   ->orderBy('event_date')
                                   ->take(5)
                                   ->get();
            $recentActivity = $cadet->attendances()
                                    ->with('event')
                                    ->latest()
                                    ->take(5)
                                    ->get();
            $unreadCount    = CadetNotification::where(function ($q) use ($cadet) {
                                $q->where('cadet_id', $cadet->id)->orWhereNull('cadet_id');
                              })->where('is_read', false)->count();

            $stats = compact(
                'totalEvents', 'attended', 'attendancePct',
                'upcomingEvents', 'recentActivity', 'unreadCount'
            );
        }

        return view('cadet.dashboard', compact('cadet', 'stats'));
    }

    /*
    |--------------------------------------------------------------------------
    | Profile Page
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        $cadet = Auth::user()->cadet->load('unit');
        return view('cadet.profile', compact('cadet'));
    }

    public function updateProfile(Request $request)
    {
        $cadet = Auth::user()->cadet;

        $data = $request->validate([
            'name'                 => ['required', 'string', 'max:255'],
            'profile_photo_base64' => ['nullable', 'string'],
            'phone'                => ['nullable', 'string', 'max:15'],
            'dob'                  => ['nullable', 'date'],
            'gender'               => ['nullable', 'in:male,female,other'],
            'address'              => ['nullable', 'string', 'max:500'],
            'course'               => ['nullable', 'string', 'max:100'],
            'student_id'           => ['nullable', 'string', 'max:50'],
        ]);

        $user = Auth::user();

        // Handle Base64 Cropped Profile Photo Upload
        if ($request->filled('profile_photo_base64')) {
            $base64Image = $request->input('profile_photo_base64');
            @list($type, $file_data) = explode(';', $base64Image);
            @list(, $file_data)      = explode(',', $file_data);
            
            $decodedImage = base64_decode($file_data);
            
            if ($decodedImage !== false) {
                // Delete old photo if it exists
                if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                    Storage::disk('public')->delete($user->profile_photo);
                }
                
                $fileName = 'profile_photos/' . uniqid() . '.jpg';
                Storage::disk('public')->put($fileName, $decodedImage);
                
                $user->profile_photo = $fileName;
            }
        }

        // Update user name and photo
        $user->name = $data['name'];
        $user->save();

        unset($data['name']);
        unset($data['profile_photo_base64']);

        $cadet->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | Attendance Page
    |--------------------------------------------------------------------------
    */
    public function attendance()
    {
        $cadet = Auth::user()->cadet;
        $records = $cadet->attendances()->with('event')->latest()->get();

        $total   = $records->count();
        $present = $records->where('status', 'present')->count();
        $absent  = $total - $present;
        $pct     = $total > 0 ? round(($present / $total) * 100, 1) : 0;

        return view('cadet.attendance', compact('cadet', 'records', 'total', 'present', 'absent', 'pct'));
    }

    /*
    |--------------------------------------------------------------------------
    | Events Page
    |--------------------------------------------------------------------------
    */
    public function events()
    {
        $cadet          = Auth::user()->cadet;
        $upcomingEvents = Event::where('event_date', '>=', now()->toDateString())
                               ->orderBy('event_date')->get();
        $pastEvents     = Event::where('event_date', '<', now()->toDateString())
                               ->orderByDesc('event_date')->get();
        $attendedIds    = $cadet->attendances()->where('status', 'present')->pluck('event_id')->toArray();

        return view('cadet.events', compact('cadet', 'upcomingEvents', 'pastEvents', 'attendedIds'));
    }

    /*
    |--------------------------------------------------------------------------
    | Unit Page
    |--------------------------------------------------------------------------
    */
    public function unit()
    {
        $cadet = Auth::user()->cadet->load('unit');
        return view('cadet.unit', compact('cadet'));
    }

    /*
    |--------------------------------------------------------------------------
    | Training & Performance Page
    |--------------------------------------------------------------------------
    */
    public function training()
    {
        $cadet = Auth::user()->cadet;
        return view('cadet.training', compact('cadet'));
    }

    /*
    |--------------------------------------------------------------------------
    | Certificates & Achievements Page
    |--------------------------------------------------------------------------
    */
    public function certificates()
    {
        $cadet = Auth::user()->cadet;
        return view('cadet.certificates', compact('cadet'));
    }

    /*
    |--------------------------------------------------------------------------
    | Leave Requests
    |--------------------------------------------------------------------------
    */
    public function leave()
    {
        $cadet  = Auth::user()->cadet;
        $leaves = $cadet->leaveRequests()->latest()->get();
        return view('cadet.leave', compact('cadet', 'leaves'));
    }

    public function storeLeave(Request $request)
    {
        $cadet = Auth::user()->cadet;

        $data = $request->validate([
            'reason'    => ['required', 'string', 'max:1000'],
            'from_date' => ['required', 'date', 'after_or_equal:today'],
            'to_date'   => ['required', 'date', 'after_or_equal:from_date'],
        ]);

        $cadet->leaveRequests()->create($data);

        return back()->with('success', 'Leave request submitted successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    public function notifications()
    {
        $cadet = Auth::user()->cadet;

        // Get notifications for this cadet + broadcast notifications (cadet_id = null)
        $notifications = CadetNotification::where(function ($q) use ($cadet) {
            $q->where('cadet_id', $cadet->id)->orWhereNull('cadet_id');
        })->latest()->get();

        // Mark all as read
        CadetNotification::where(function ($q) use ($cadet) {
            $q->where('cadet_id', $cadet->id)->orWhereNull('cadet_id');
        })->where('is_read', false)->update(['is_read' => true]);

        return view('cadet.notifications', compact('cadet', 'notifications'));
    }
}
