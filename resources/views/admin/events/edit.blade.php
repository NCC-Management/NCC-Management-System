@extends('layouts.admin')

@section('content')
<div class="p-6">

    <h2 class="text-2xl font-bold mb-6">Edit Event</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('events.update',$event->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold">Event Title</label>
            <input type="text" name="title" 
                   value="{{ $event->title }}"
                   class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Event Date</label>
            <input type="date" name="date" 
                   value="{{ $event->date }}"
                   class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Description</label>
            <textarea name="description" 
                      class="w-full border p-2 rounded"
                      rows="4">{{ $event->description }}</textarea>
        </div>

        <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
            Update Event
        </button>

        <a href="{{ route('events.index') }}" 
           class="ml-3 text-gray-600">
            Cancel
        </a>

    </form>

</div>
@endsection