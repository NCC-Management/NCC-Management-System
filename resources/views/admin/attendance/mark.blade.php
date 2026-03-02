@extends('layouts.admin')

@section('content')

<h2 class="mb-3">Mark Attendance</h2>

<form method="POST" action="{{ route('attendance.store') }}">
@csrf

{{-- Select Event --}}
<div class="mb-3">
    <label class="form-label">Select Event</label>
    <select name="event_id" class="form-control" required>
        <option value="">-- Select Event --</option>
        @foreach($events as $event)
            <option value="{{ $event->id }}">{{ $event->title }}</option>
        @endforeach
    </select>
</div>

{{-- Attendance Table --}}
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Cadet Name</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cadets as $cadet)
        <tr>
            <td>{{ $cadet->user->name }}</td>
            <td>
                <select name="attendance[{{ $cadet->id }}]" class="form-control" required>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                </select>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<button class="btn btn-success">Save Attendance</button>

</form>

@endsection