@extends('layouts.admin')
@section('content')

<h2>Mark Attendance</h2>

<form method="POST" action="{{ route('attendance.store') }}">
@csrf

<select name="cadet_id" class="form-control mb-2">
@foreach($cadets as $cadet)
<option value="{{ $cadet->id }}">
    {{ $cadet->user->name }}
</option>
@endforeach
</select>

<input type="date" name="date" class="form-control mb-2">

<select name="status" class="form-control mb-2">
<option value="present">Present</option>
<option value="absent">Absent</option>
</select>

<button class="btn btn-success">Save</button>
</form>

@endsection