@extends('layouts.admin')
@section('content')

<h2>Edit Cadet</h2>

<form method="POST" action="{{ route('cadets.update',$cadet) }}">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Enrollment No</label>
    <input type="text" name="enrollment_no" value="{{ $cadet->enrollment_no }}" class="form-control">
</div>

<button class="btn btn-success">Update</button>
</form>

@endsection