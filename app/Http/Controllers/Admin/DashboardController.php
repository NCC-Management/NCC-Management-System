<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Event;
use App\Models\Attendance;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCadets = Cadet::count();
        $totalEvents = Event::count();
        $present = Attendance::where('status','present')->count();
        $absent = Attendance::where('status','absent')->count();

        return view('admin.dashboard', compact(
            'totalCadets',
            'totalEvents',
            'present',
            'absent'
        ));
    }
}