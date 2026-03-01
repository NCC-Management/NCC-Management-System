@extends('layouts.admin')
@section('content')

<h2>Units</h2>

<a href="{{ route('units.create') }}" class="btn btn-primary mb-3">Add Unit</a>

<table class="table table-bordered">
<tr>
    <th>Name</th>
    <th>Action</th>
</tr>

@foreach($units as $unit)
<tr>
    <td>{{ $unit->name }}</td>
    <td>
        <a href="{{ route('units.edit',$unit) }}" class="btn btn-warning btn-sm">Edit</a>

        <form method="POST" action="{{ route('units.destroy',$unit) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</table>

@endsection