@extends('layouts.admin')

@section('content')

<h2 class="text-2xl font-bold mb-6">Create Event</h2>

<form method="POST" action="{{ route('events.store') }}">
    @csrf

  <div class="mb-4">
    <label>Unit</label>
    <select name="unit_id" class="w-full border p-2 rounded" required>
        <option value="">Select Unit</option>
        @foreach($units as $unit)
            <option value="{{ $unit->id }}">
                {{ $unit->unit_name }}
            </option>
        @endforeach
    </select>
</div>
    <div class="mb-4">
        <label>Title</label>
        <input type="text" name="title" 
               class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label>Event Date</label>
        <input type="date" name="event_date" 
               class="w-full border p-2 rounded" required>
    </div>

    <div class="mb-4">
        <label>Description</label>
        <textarea name="description" 
                  class="w-full border p-2 rounded"></textarea>
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Save Event
    </button>

</form>

@endsection