<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cadet_id' => 'required|exists:cadets,id',
            'event_id' => 'required|exists:events,id',
            'status' => 'required|in:present,absent'
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'cadet_id' => $request->cadet_id,
                'event_id' => $request->event_id
            ],
            ['status' => $request->status]
        );

        return response()->json([
            'message' => 'Attendance marked',
            'attendance' => $attendance
        ]);
    }
}
