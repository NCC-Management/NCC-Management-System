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
    public function index(Request $request)
    {
        // Adjust ordering/fields to match your Event model
        $events = Event::orderBy('created_at', 'desc')->get();

        // Load cadets with their user relation used in the view
        $cadets = Cadet::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.attendance.index', compact('events', 'cadets'));
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

        return redirect()->route('admin.attendance.index')
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