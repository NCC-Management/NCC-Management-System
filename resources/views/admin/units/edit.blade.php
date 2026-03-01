@extends('layouts.admin')
@section('content')

<h2>Edit Unit</h2>

<form method="POST" action="{{ route('units.update',$unit) }}">
@csrf
@method('PUT')

<div class="mb-3">
    <label>Unit Name</label>
    <input type="text" name="name" value="{{ $unit->name }}" class="form-control">
</div>

<button class="btn btn-success">Update</button>
</form>

@endsection