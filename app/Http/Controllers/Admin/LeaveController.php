<?php

namespace App\Http\Controllers\Admin;

use App\Models\LeaveRequest;
use App\Http\Controllers\Controller;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = LeaveRequest::with('cadet.user')->latest()->get();
        return view('admin.leave.index', compact('leaves'));
    }

    public function approve(LeaveRequest $leave)
    {
        $leave->update(['status' => 'approved']);
        return back()->with('success', 'Leave request approved.');
    }

    public function reject(LeaveRequest $leave)
    {
        $leave->update(['status' => 'rejected']);
        return back()->with('success', 'Leave request rejected.');
    }
}
