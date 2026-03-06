@extends('layouts.admin')

@section('content')

<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-2">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Attendance</li>
        </ol>
    </nav>

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Mark Attendance</h5>
                <small class="text-muted">Select an event and mark cadet attendance using quick buttons.</small>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-list-ul"></i> Records
                </a>
            </div>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger small">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.attendance.store') }}">
                @csrf

                <div class="row g-3 mb-3 align-items-end">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Event</label>
                        <select name="event_id" class="form-select" required>
                            <option value="">-- Select event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }} — {{ optional($event->event_date)->format('Y-m-d') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="button" id="mark-all-present" class="btn btn-outline-success w-100">
                            <i class="bi bi-check2-all me-1"></i> Mark All Present
                        </button>
                        <button type="button" id="reset-all" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:50%">Cadet</th>
                                <th class="text-center" style="width:25%">Present</th>
                                <th class="text-center" style="width:25%">Absent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cadets as $cadet)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:40px;height:40px;font-weight:600;">
                                                {{ strtoupper(substr($cadet->user->name ?? '-', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $cadet->user->name ?? '—' }}</div>
                                                <div class="small text-muted">Enroll: {{ $cadet->enrollment_no ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <input type="hidden" name="attendance[{{ $cadet->id }}]" id="attendance-input-{{ $cadet->id }}" value="{{ old("attendance.{$cadet->id}", 'absent') }}">
                                        <div class="btn-group" role="group" aria-label="Attendance toggle">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-success attendance-toggle {{ old("attendance.{$cadet->id}") === 'present' ? 'active' : '' }}"
                                                    data-cadet="{{ $cadet->id }}"
                                                    data-value="present">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Attendance toggle">
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger attendance-toggle {{ old("attendance.{$cadet->id}") === 'absent' ? 'active' : '' }}"
                                                    data-cadet="{{ $cadet->id }}"
                                                    data-value="absent">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">No cadets found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Save Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($attendances) && $attendances->isNotEmpty())
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0">Recent Attendance Records</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Event</th>
                                <th>Cadet</th>
                                <th>Status</th>
                                <th class="text-end">Recorded</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $record)
                                <tr>
                                    <td>{{ $record->event->title ?? '—' }}</td>
                                    <td>{{ $record->cadet->user->name ?? '—' }}</td>
                                    <td>
                                        @if($record->status === 'present')
                                            <span class="badge bg-success">Present</span>
                                        @else
                                            <span class="badge bg-danger">Absent</span>
                                        @endif
                                    </td>
                                    <td class="text-end small text-muted">{{ optional($record->created_at)->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // toggle handler
    document.querySelectorAll('.attendance-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const cadetId = this.dataset.cadet;
            const value = this.dataset.value;
            const input = document.getElementById('attendance-input-' + cadetId);
            if (!input) return;

            // set value
            input.value = value;

            // remove active class from both buttons for this cadet then activate clicked
            const selector = '[data-cadet="' + cadetId + '"]';
            document.querySelectorAll(selector).forEach(b => b.classList.remove('active', 'btn-success', 'btn-danger'));
            // add appropriate classes to indicate state
            if (value === 'present') {
                this.classList.add('active', 'btn-success');
                // mark the absent button muted
                const other = document.querySelector(selector + '[data-value="absent"]');
                if (other) other.classList.remove('active', 'btn-danger');
            } else {
                this.classList.add('active', 'btn-danger');
                const other = document.querySelector(selector + '[data-value="present"]');
                if (other) other.classList.remove('active', 'btn-success');
            }
        });
    });

    // Mark all present
    const markAllBtn = document.getElementById('mark-all-present');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function () {
            document.querySelectorAll('.attendance-toggle[data-value="present"]').forEach(b => b.click());
        });
    }

    // Reset all to absent
    const resetBtn = document.getElementById('reset-all');
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            document.querySelectorAll('.attendance-toggle[data-value="absent"]').forEach(b => b.click());
        });
    }

    // initialize buttons visually based on current hidden inputs (server-side old values)
    document.querySelectorAll('input[id^="attendance-input-"]').forEach(input => {
        const id = input.id.replace('attendance-input-', '');
        const val = input.value || 'absent';
        const btn = document.querySelector('.attendance-toggle[data-cadet="' + id + '"][data-value="' + val + '"]');
        if (btn) btn.classList.add('active', val === 'present' ? 'btn-success' : 'btn-danger');
    });
});
</script>

@endsection