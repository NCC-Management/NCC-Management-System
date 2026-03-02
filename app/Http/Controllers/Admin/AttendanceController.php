<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Cadet;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
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

        $cadets = Cadet::with('user')
            ->whereHas('user', function ($q) {
                $q->where('role', 'student');
            })
            ->get();

        return view('admin.attendance.create', compact('events', 'cadets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
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
            ->with('success', 'Attendance saved successfully');
    }

    public function myAttendance()
    {
        $attendances = Attendance::with('event')
            ->whereHas('cadet', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->get();

        return view('cadet.attendance.index', compact('attendances'));
    }
}