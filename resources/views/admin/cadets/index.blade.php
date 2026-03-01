@extends('layouts.admin')
@section('content')

<h2>Cadets</h2>

<a href="{{ route('cadets.create') }}" class="btn btn-primary mb-3">Add Cadet</a>

<table class="table table-bordered">
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Enrollment</th>
    <th>Action</th>
</tr>

@foreach($cadets as $cadet)
<tr>
    <td>{{ $cadet->user->name }}</td>
    <td>{{ $cadet->user->email }}</td>
    <td>{{ $cadet->enrollment_no }}</td>
    <td>
        <a href="{{ route('cadets.edit',$cadet) }}" class="btn btn-warning btn-sm">Edit</a>

        <form method="POST" action="{{ route('cadets.destroy',$cadet) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</table>

@endsection