@extends('layouts.admin')

@section('content')

<div class="bg-white p-6 rounded shadow">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            Events Management
        </h2>

        <a href="{{ route('events.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded shadow">
            + Add Event
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Empty State -->
    @if($events->count() == 0)
        <div class="text-center py-10 text-gray-500">
            No events created yet.
        </div>
    @else

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border">Unit</th>
                    <th class="p-3 border">Title</th>
                    <th class="p-3 border">Event Date</th>
                    <th class="p-3 border">Description</th>
                    <th class="p-3 border">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($events as $event)
                <tr class="text-center border-t hover:bg-gray-50">

                    <!-- Unit -->
                    <td class="p-3 border">
                        {{ $event->unit->unit_name ?? 'N/A' }}
                    </td>

                    <!-- Title -->
                    <td class="p-3 border font-semibold">
                        {{ $event->title }}
                    </td>

                    <!-- Date -->
                    <td class="p-3 border">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                    </td>

                    <!-- Description -->
                    <td class="p-3 border">
                        {{ $event->description }}
                    </td>

                    <!-- Actions -->
                    <td class="p-3 border space-x-2">

                        <!-- Update Button -->
                        <a href="{{ route('events.edit',$event->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                           Update
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('events.destroy',$event->id) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Are you sure you want to delete this event?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Delete
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @endif

</div>

@endsection