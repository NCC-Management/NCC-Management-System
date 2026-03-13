<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadet extends Model
{
    protected $fillable = [
        'user_id',
        'unit_id',
        'enrollment_no',
        'rank',
        'student_id',
        'course',
        'phone',
        'dob',
        'gender',
        'address',
        'profile_completed',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'dob'               => 'date',
        'profile_completed' => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function notifications()
    {
        return $this->hasMany(CadetNotification::class);
    }

    // ── Status Helpers ─────────────────────────────────────

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    // ── Attendance Helpers ─────────────────────────────────

    public function attendancePercentage(): float
    {
        $total   = $this->attendances()->count();
        if ($total === 0) return 0;
        $present = $this->attendances()->where('status', 'present')->count();
        return round(($present / $total) * 100, 1);
    }
}