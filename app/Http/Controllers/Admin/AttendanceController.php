<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Cadet;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
{
    // only include attendances for cadets whose user has the "student" role
    $attendances = Attendance::with(['cadet.user', 'event'])
        ->whereHas('cadet.user', function ($q) {
            $q->where('role', 'student');
        })
        ->get();
    return view('admin.attendance.index', compact('attendances'));
}

    public function create()
    {
        $events = Event::all();
        // only list cadets whose associated user is a student
        $cadets = Cadet::with('user')
            ->whereHas('user', function ($q) {
                $q->where('role', 'student');
            })
            ->get();

        // also pull existing attendance records so the form can display them
        $attendances = Attendance::with(['cadet.user', 'event'])
            ->whereHas('cadet.user', function ($q) {
                $q->where('role', 'student');
            })
            ->get();

        return view('admin.attendance.create', compact('events', 'cadets', 'attendances'));
    }

    public function store(Request $request)
{
    $request->validate([
        'event_id' => 'required',
        'attendance' => 'required|array'
    ]);

    foreach ($request->attendance as $cadet_id => $status) {

        Attendance::updateOrCreate(
            [
                'event_id' => $request->event_id,
                'cadet_id' => $cadet_id,
            ],
            [
                'status' => $status
            ]
        );
    }

    return redirect()->route('attendance.index')
        ->with('success','Attendance Saved Successfully');
}

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return back();
    }


    public function myAttendance()
    {
        $attendances = Attendance::with('event')
            ->whereHas('cadet', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return view('cadet.attendance.index', compact('attendances'));
    }
}
