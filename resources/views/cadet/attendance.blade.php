@extends('layouts.cadet-new')
@section('title', 'My Attendance')
@section('page-title', 'My Attendance')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    <!-- Top Stats Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Events -->
        <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-400 to-blue-600 opacity-90"></div>
            <div class="flex items-start justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner border border-blue-100/50 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-calendar-check text-2xl"></i>
                </div>
            </div>
            <div>
                <div class="text-4xl font-black text-gray-800 tracking-tight leading-none mb-2">{{ $total }}</div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Events</h3>
            </div>
        </div>

        <!-- Present -->
        <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-green-400 to-green-600 opacity-90"></div>
            <div class="flex items-start justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center shadow-inner border border-green-100/50 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-user-check text-2xl"></i>
                </div>
            </div>
            <div>
                <div class="text-4xl font-black text-gray-800 tracking-tight leading-none mb-2">{{ $present }}</div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Present</h3>
            </div>
        </div>

        <!-- Absent -->
        <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-400 to-red-600 opacity-90"></div>
            <div class="flex items-start justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center shadow-inner border border-red-100/50 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-user-xmark text-2xl"></i>
                </div>
            </div>
            <div>
                <div class="text-4xl font-black text-gray-800 tracking-tight leading-none mb-2">{{ $absent }}</div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Absent</h3>
            </div>
        </div>

        <!-- Rate -->
        <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute bottom-0 left-0 w-full h-1.5 {{ $pct >= 75 ? 'bg-gradient-to-r from-green-400 to-green-600' : ($pct >= 50 ? 'bg-gradient-to-r from-yellow-400 to-yellow-600' : 'bg-gradient-to-r from-red-400 to-red-600') }} opacity-90"></div>
            <div class="flex items-start justify-between mb-8">
                <div class="w-14 h-14 rounded-2xl {{ $pct >= 75 ? 'bg-green-50 text-green-600 border-green-100/50' : ($pct >= 50 ? 'bg-yellow-50 text-yellow-600 border-yellow-100/50' : 'bg-red-50 text-red-600 border-red-100/50') }} flex items-center justify-center shadow-inner border group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chart-pie text-2xl"></i>
                </div>
                <span class="{{ $pct >= 75 ? 'bg-green-50 text-green-700 border-green-100' : ($pct >= 50 ? 'bg-yellow-50 text-yellow-700 border-yellow-100' : 'bg-red-50 text-red-700 border-red-100') }} text-xs font-bold px-3 py-1 rounded-xl border flex items-center gap-1.5 shadow-sm">
                    {{ $pct >= 75 ? 'Good' : ($pct >= 50 ? 'Fair' : 'Low') }}
                </span>
            </div>
            <div>
                <div class="text-4xl font-black text-gray-800 tracking-tight leading-none mb-2">{{ $pct }}<span class="text-2xl text-gray-400 font-bold ml-1">%</span></div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Attendance Rate</h3>
            </div>
        </div>

    </div>

    <!-- Attendance Table Panel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                <i class="fa-solid fa-list-check text-xl"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-xl">Attendance Records</h3>
                <p class="text-sm text-gray-500 font-medium">Detailed history of all your parades and events</p>
            </div>
        </div>

        <div class="p-0">
            @if(count($records) == 0)
            <div class="p-16 text-center bg-white">
                <div class="w-20 h-20 rounded-2xl bg-gray-50 border border-gray-100 text-gray-300 flex items-center justify-center mx-auto mb-5 text-3xl shadow-sm">
                    <i class="fa-regular fa-clipboard"></i>
                </div>
                <p class="text-gray-500 font-medium text-base">No attendance records found.<br>Records will appear here once marked by your officer.</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/80 text-gray-400 text-xs font-bold uppercase tracking-widest border-b border-gray-100">
                            <th class="px-8 py-5 w-16">#</th>
                            <th class="px-8 py-5">Event Name</th>
                            <th class="px-8 py-5">Date</th>
                            <th class="px-8 py-5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 bg-white text-sm">
                        @foreach($records as $i => $rec)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-5 text-gray-400 font-bold">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-8 py-5 text-gray-800 font-bold group-hover:text-blue-600 transition-colors">{{ $rec->event?->title ?? '—' }}</td>
                            <td class="px-8 py-5 text-gray-500 font-medium whitespace-nowrap">
                                <i class="fa-regular fa-calendar mr-2 text-gray-400"></i>
                                {{ $rec->event?->event_date ? \Carbon\Carbon::parse($rec->event->event_date)->format('d M Y') : '—' }}
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                @if($rec->status === 'present')
                                <span class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-green-200 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span> Present
                                </span>
                                @elseif($rec->status === 'absent')
                                <span class="inline-flex items-center gap-2 bg-red-50 text-red-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-red-200 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span> Absent
                                </span>
                                @else
                                <span class="inline-flex items-center gap-2 bg-gray-50 text-gray-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-gray-200 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-gray-500"></span> {{ ucfirst($rec->status) }}
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
    </div>

</div>

@endsection
