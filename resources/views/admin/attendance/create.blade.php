@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto bg-white p-8 rounded shadow">

    <h2 class="text-2xl font-bold mb-6 text-gray-800">
        Mark Attendance
    </h2>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('attendance.store') }}">
        @csrf

        <!-- Select Event -->
        <div class="mb-6">
            <label class="block font-semibold mb-2 text-gray-700">
                Select Event
            </label>

            <select name="event_id"
                    class="w-full border border-gray-300 p-3 rounded"
                    required>
                <option value="">-- Select Event --</option>

                @foreach($events as $event)
                    <option value="{{ $event->id }}">
                        {{ $event->title }} ({{ $event->event_date }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Cadet Attendance Table -->
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border">Cadet Name</th>
                        <th class="p-3 border text-center">Present</th>
                        <th class="p-3 border text-center">Absent</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($cadets as $cadet)
                        <tr class="text-center">
                            <td class="p-3 border text-left">
                                {{ $cadet->user->name ?? 'No Name' }}
                            </td>

                            <td class="border">
                                <input type="radio"
                                       name="attendance[{{ $cadet->id }}]"
                                       value="present"
                                       required>
                            </td>

                            <td class="border">
                                <input type="radio"
                                       name="attendance[{{ $cadet->id }}]"
                                       value="absent"
                                       required>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Submit -->
        <div class="mt-6">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
                Save Attendance
            </button>
        </div>

    </form>

</div>

@endsection

@if(isset($attendances) && $attendances->isNotEmpty())
    <div class="max-w-5xl mx-auto bg-white p-8 rounded shadow mt-8">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Existing Attendance Records</h3>
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border">Event</th>
                        <th class="p-3 border">Cadet</th>
                        <th class="p-3 border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $record)
                        <tr class="text-center">
                            <td class="p-3 border text-left">
                                {{ $record->event->title ?? 'N/A' }} ({{ $record->event->event_date ?? '' }})
                            </td>
                            <td class="p-3 border text-left">
                                {{ $record->cadet->user->name ?? 'N/A' }}
                            </td>
                            <td class="p-3 border">
                                @if($record->status === 'present')
                                    <span class="text-green-600 font-semibold">Present</span>
                                @else
                                    <span class="text-red-600 font-semibold">Absent</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif