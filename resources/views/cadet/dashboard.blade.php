@extends('layouts.cadet-new')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    @php 
        $cadetUser = auth()->user(); 
        $cadetRec = $cadetUser->cadet; 

        if ($cadetRec && $cadetRec->isApproved()) {
            $totalEvents   = $stats['totalEvents'] ?? 0;
            $attended      = $stats['attended'] ?? 0;
            $attendancePct = $stats['attendancePct'] ?? 0;
            $upcoming      = $stats['upcomingEvents'] ?? collect();
            $activity      = $stats['recentActivity'] ?? collect();
        }
    @endphp

    <div class="max-w-7xl mx-auto space-y-10 pb-10">
        {{-- ─── PENDING STATE ─────────────────────────────────────────────────── --}}
        @if(!$cadetRec || $cadetRec->isPending())
        <div class="bg-amber-50 border-b-4 border-amber-400 rounded-3xl p-10 text-center max-w-2xl mx-auto mt-10 shadow-md">
            <div class="w-24 h-24 rounded-2xl bg-white text-amber-500 flex items-center justify-center mx-auto mb-8 text-5xl shadow-sm border border-amber-100">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-4 tracking-tight">Enrollment Under Review</h2>
            <p class="text-gray-600 mb-10 text-lg font-medium leading-relaxed">
                Your NCC enrollment request has been submitted successfully.<br>
                Please wait for admin approval to access full dashboard features.
            </p>
            <div class="inline-flex items-center bg-white px-8 py-4 rounded-2xl border border-gray-200 text-base shadow-sm">
                <span class="text-gray-500 font-bold uppercase tracking-widest text-xs mr-3">Enrollment No</span> 
                <span class="text-amber-600 font-extrabold text-lg tracking-wide">{{ $cadetRec->enrollment_no ?? 'N/A' }}</span>
            </div>
        </div>

        {{-- ─── REJECTED STATE ──────────────────────────────────────────────────── --}}
        @elseif($cadetRec->isRejected())
        <div class="bg-red-50 border-b-4 border-red-500 rounded-3xl p-10 text-center max-w-2xl mx-auto mt-10 shadow-md">
            <div class="w-24 h-24 rounded-2xl bg-white text-red-500 flex items-center justify-center mx-auto mb-8 text-5xl shadow-sm border border-red-100">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-4 tracking-tight">Application Rejected</h2>
            <p class="text-gray-600 mb-8 text-lg font-medium">
                Unfortunately, your NCC enrollment has been rejected by the administration.
            </p>
            @if($cadetRec->rejection_reason)
            <div class="bg-white px-8 py-6 rounded-2xl border border-gray-200 text-left mb-4 inline-block max-w-lg shadow-sm w-full">
                <strong class="text-gray-400 uppercase tracking-widest text-xs font-bold block mb-2">Reason for rejection</strong>
                <span class="text-red-600 font-semibold text-base">{{ $cadetRec->rejection_reason }}</span>
            </div>
            @endif
        </div>

        {{-- ─── APPROVED / FULL DASHBOARD ──────────────────────────────────────── --}}
        @else
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-[#0f172a] to-[#1e1b4b] rounded-3xl p-10 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-8 border border-gray-800 transition-all duration-300 hover:shadow-2xl">
            <!-- Decorative SVG -->
            <svg class="absolute right-0 top-0 h-full w-2/3 text-white/5 transform translate-x-1/3 rotate-12" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100" />
            </svg>
            <div class="absolute -left-20 -top-20 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

            <div class="relative z-10">
                <p class="text-blue-300 font-bold tracking-widest uppercase text-xs mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span> Active Cadet Portal
                </p>
                <h2 class="text-4xl lg:text-5xl font-extrabold mb-3 tracking-tight">Jai Hind, {{ explode(' ', trim($cadetUser->name))[0] }}! 🇮🇳</h2>
                <p class="text-gray-300 text-base lg:text-lg font-medium flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-blue-400"></i> {{ $cadetRec->unit?->unit_name ?? 'Unit Not Assigned' }} &bull; Bn: {{ $cadetRec->unit?->battalion ?? '—' }}
                </p>
            </div>
            @if(isset($upcoming) && $upcoming->count() > 0)
            <div class="relative z-10 bg-white/10 backdrop-blur-xl rounded-2xl px-8 py-5 border border-white/10 text-center shadow-2xl min-w-[200px]">
                <p class="text-xs text-blue-200 uppercase tracking-widest font-extrabold mb-2">Next Event</p>
                <p class="font-bold text-2xl tracking-tight text-white">{{ \Carbon\Carbon::parse($upcoming->first()->event_date)->format('D, d M') }}</p>
                <p class="text-sm font-medium text-blue-100 mt-1 opacity-80">{{ \Carbon\Carbon::parse($upcoming->first()->event_date)->format('H:i') }} HRS</p>
            </div>
            @else
            <div class="relative z-10 bg-white/5 backdrop-blur-xl rounded-2xl px-8 py-5 border border-white/10 text-center shadow-2xl min-w-[200px]">
                <p class="text-xs text-gray-400 uppercase tracking-widest font-extrabold mb-2">Next Event</p>
                <p class="font-bold text-xl text-gray-300">No Events</p>
            </div>
            @endif
        </div>

        <!-- Premium Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Metric 1: Attendance Rate -->
            <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 group">
                <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-90"></div>
                <div class="flex justify-between items-start mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-inner border border-emerald-100/50">
                        <i class="fa-solid fa-chart-pie text-2xl"></i>
                    </div>
                    <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1 rounded-xl border border-emerald-100 flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity shadow-sm">
                        <i class="fa-solid fa-arrow-trend-up"></i> Rate
                    </span>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-gray-800 tracking-tight leading-none mb-2">{{ $attendancePct }}<span class="text-2xl text-gray-400 font-bold ml-1">%</span></h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Attendance</p>
                </div>
            </div>

            <!-- Metric 2: Parades Attended -->
            <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 group">
                <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-400 to-blue-600 opacity-90"></div>
                <div class="flex justify-between items-start mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-inner border border-blue-100/50">
                        <i class="fa-solid fa-person-military-pointing text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-gray-800 tracking-tight leading-none mb-2">{{ $attended }}</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Attended Parades</p>
                </div>
            </div>

            <!-- Metric 3: Total Events -->
            <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 group">
                <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-purple-400 to-purple-600 opacity-90"></div>
                <div class="flex justify-between items-start mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-inner border border-purple-100/50">
                        <i class="fa-solid fa-calendar-check text-2xl"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-4xl font-black text-gray-800 tracking-tight leading-none mb-2">{{ $totalEvents }}</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Total Events</p>
                </div>
            </div>

            <!-- Metric 4: Upcoming -->
            <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 group">
                <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-amber-400 to-amber-600 opacity-90"></div>
                <div class="flex justify-between items-start mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-inner border border-amber-100/50">
                        <i class="fa-solid fa-clock text-2xl"></i>
                    </div>
                    @if(isset($upcoming) && $upcoming->count() > 0)
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                    </span>
                    @endif
                </div>
                <div>
                    <h3 class="text-4xl font-black text-gray-800 tracking-tight leading-none mb-2">{{ isset($upcoming) ? $upcoming->count() : 0 }}</h3>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Upcoming Duties</p>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Recent Activity -->
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl flex flex-col h-full">
                    <div class="px-8 py-6 border-b border-gray-100 bg-white flex justify-between items-center relative">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500 rounded-tl-3xl"></div>
                        <h3 class="font-extrabold text-gray-900 text-xl tracking-tight">Activity Log</h3>
                        <a href="{{ route('cadet.attendance') }}" class="text-xs text-blue-600 hover:text-blue-800 font-bold tracking-widest uppercase bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-full transition-colors">View All</a>
                    </div>
                    <div class="divide-y divide-gray-50 flex-1">
                        @forelse($activity as $rec)
                        <div class="p-6 hover:bg-gray-50/50 transition-colors flex items-center justify-between group">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 text-gray-400 flex items-center justify-center group-hover:bg-blue-50 group-hover:text-blue-500 group-hover:border-blue-100 transition-colors">
                                    <i class="fa-solid fa-clipboard-check text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-base mb-1 group-hover:text-blue-700 transition-colors">{{ $rec->event?->title ?? '—' }}</h4>
                                    <div class="flex items-center gap-2 text-xs text-gray-500 font-semibold tracking-wide uppercase">
                                        <i class="fa-regular fa-calendar"></i>
                                        <span>{{ $rec->event?->event_date ? \Carbon\Carbon::parse($rec->event->event_date)->format('d M Y') : '—' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if($rec->status === 'present')
                                <span class="inline-flex items-center justify-center w-28 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-bold border border-emerald-100">
                                    Present
                                </span>
                                @elseif($rec->status === 'absent')
                                <span class="inline-flex items-center justify-center w-28 py-2 bg-red-50 text-red-700 rounded-xl text-xs font-bold border border-red-100">
                                    Absent
                                </span>
                                @else
                                <span class="inline-flex items-center justify-center w-28 py-2 bg-gray-50 text-gray-700 rounded-xl text-xs font-bold border border-gray-200">
                                    {{ ucfirst($rec->status) }}
                                </span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="p-16 text-center h-full flex flex-col items-center justify-center">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <i class="fa-solid fa-list-ul text-3xl text-gray-300"></i>
                            </div>
                            <p class="text-gray-500 font-semibold text-sm">No recent activity recorded.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                
                <!-- Upcoming Schedule -->
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl">
                    <div class="px-8 py-6 border-b border-gray-100 bg-white relative">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-amber-500 rounded-tl-3xl"></div>
                        <h3 class="font-extrabold text-gray-900 text-xl tracking-tight">Timeline</h3>
                    </div>
                    <div class="p-8">
                        @if(isset($upcoming) && $upcoming->count() > 0)
                        <div class="relative border-l-2 border-gray-100 ml-3 space-y-8 my-2">
                            @foreach($upcoming as $ev)
                            <div class="relative pl-8 group">
                                <div class="absolute w-4 h-4 bg-white border-4 border-amber-500 rounded-full -left-[9px] top-1 shadow-sm group-hover:scale-125 transition-transform duration-300"></div>
                                <p class="text-xs text-gray-400 font-extrabold mb-1.5 tracking-widest uppercase">{{ \Carbon\Carbon::parse($ev->event_date)->format('d M Y • H:i') }}</p>
                                <h4 class="font-bold text-gray-900 text-lg leading-tight mb-2 group-hover:text-amber-600 transition-colors">{{ $ev->title }}</h4>
                                <p class="text-sm text-gray-500 font-medium flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-gray-400"></i> {{ $ev->location ?? 'NCC Unit Ground' }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-10">
                            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-regular fa-calendar-xmark text-3xl text-gray-300"></i>
                            </div>
                            <p class="text-gray-500 font-semibold text-sm">No upcoming events scheduled.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Cadet Profile Mini -->
                <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-8 transition-all duration-300 hover:shadow-2xl relative overflow-hidden group">
                    <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-gray-200 to-gray-300"></div>
                    <div class="flex items-center gap-5 mb-8">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 text-gray-600 flex items-center justify-center text-xl font-black shadow-inner border border-white overflow-hidden relative">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg leading-tight">{{ $cadetUser->name }}</h3>
                            <p class="text-xs text-gray-500 font-bold tracking-widest uppercase mt-1">{{ $cadetRec->enrollment_no }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4 mb-8">
                        <div class="bg-gray-50 rounded-2xl p-4 flex justify-between items-center group-hover:bg-gray-100 transition-colors">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Current Rank</span>
                            <span class="font-extrabold text-gray-900">{{ $cadetRec->rank ?? 'Cadet' }}</span>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-4 flex justify-between items-center group-hover:bg-gray-100 transition-colors">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Program</span>
                            <span class="font-extrabold text-gray-900">{{ $cadetRec->course ?? '—' }}</span>
                        </div>
                    </div>

                    <a href="{{ route('cadet.profile') }}" class="w-full flex items-center justify-center py-4 bg-gray-900 hover:bg-black text-white rounded-2xl font-bold transition-all duration-300 shadow-lg shadow-gray-900/20 hover:shadow-gray-900/40">
                        View Full Profile
                    </a>
                </div>

            </div>
        </div>

        @endif
    </div>
@endsection
