// the cadet layout doesn't exist; use the admin layout which is available
@extends('layouts.admin')

@section('content')

<div class="bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold mb-6">My Attendance Records</h2>

    @if($attendances->isEmpty())
        <div class="text-red-600 font-semibold">
            No attendance records found.
        </div>
    @else

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 border">Event</th>
                        <th class="p-3 border">Date</th>
                        <th class="p-3 border">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($attendances as $attendance)
                        <tr class="text-center">
                            <td class="p-3 border">
                                {{ $attendance->event->title ?? 'N/A' }}
                            </td>

                            <td class="p-3 border">
                                {{ $attendance->event->event_date ?? 'N/A' }}
                            </td>

                            <td class="p-3 border">
                                @if($attendance->status == 'present')
                                    <span class="text-green-600 font-semibold">
                                        Present
                                    </span>
                                @else
                                    <span class="text-red-600 font-semibold">
                                        Absent
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

</div>

@endsection