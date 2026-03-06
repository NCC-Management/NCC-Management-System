@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0 mb-2">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.attendance.index') }}">Attendance</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mark</li>
        </ol>
    </nav>

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Mark Attendance</h5>
                <small class="text-muted">Pick an event and mark cadet attendance.</small>
            </div>
            <div>
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
                <div class="alert alert-danger">
                    <ul class="mb-0 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.attendance.store') }}">
                @csrf

                <div class="row g-3 mb-4 align-items-end">
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
                        <div class="form-text">Choose event to record attendance for.</div>
                    </div>

                    <div class="col-md-4 d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Save Attendance
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:55%">Cadet</th>
                                <th class="text-center" style="width:22%">Present</th>
                                <th class="text-center" style="width:23%">Absent</th>
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
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   name="attendance[{{ $cadet->id }}]"
                                                   id="present-{{ $cadet->id }}"
                                                   value="present"
                                                   {{ old("attendance.{$cadet->id}") === 'present' ? 'checked' : '' }}
                                                   required>
                                            <label class="form-check-label text-success" for="present-{{ $cadet->id }}">Present</label>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                   name="attendance[{{ $cadet->id }}]"
                                                   id="absent-{{ $cadet->id }}"
                                                   value="absent"
                                                   {{ old("attendance.{$cadet->id}") === 'absent' ? 'checked' : '' }}>
                                            <label class="form-check-label text-danger" for="absent-{{ $cadet->id }}">Absent</label>
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
@endsection