@extends('layouts.cadet-new')
@section('title', 'My Unit')
@section('page-title', 'My Unit')

@section('content')

@if($cadet->unit)
<div class="max-w-7xl mx-auto space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        {{-- Left Column: Unit Info --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <!-- Background Graphic -->
                <div class="h-32 bg-gradient-to-br from-cyan-600 to-blue-800 relative overflow-hidden">
                    <svg class="absolute inset-0 w-full h-full text-white/10" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <polygon points="0,100 100,0 100,100" />
                    </svg>
                </div>
                
                <!-- Unit Icon & Title -->
                <div class="px-8 pb-8 text-center relative -mt-16">
                    <div class="w-32 h-32 rounded-3xl bg-white p-2 mx-auto mb-5 shadow-md border border-gray-100">
                        <div class="w-full h-full rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white text-4xl font-extrabold shadow-inner border border-white/20">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                    </div>
                    
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight leading-tight">{{ $cadet->unit->unit_name }}</h2>
                    <p class="text-sm text-gray-500 mt-2 font-bold tracking-wide">{{ $cadet->unit->battalion }} &bull; {{ $cadet->unit->state }}</p>
                </div>

                <!-- Info Details -->
                <div class="border-t border-gray-100 bg-gray-50/30">
                    <div class="divide-y divide-gray-100/60">
                        @foreach([
                            [
                                'icon' => 'fa-user-tie',
                                'label' => 'Officer in Charge',
                                'value' => $cadet->unit->officer_name ?? 'Not specified'
                            ],
                            [
                                'icon' => 'fa-location-dot',
                                'label' => 'Location',
                                'value' => $cadet->unit->location ?? 'Not specified'
                            ],
                            [
                                'icon' => 'fa-phone',
                                'label' => 'Contact',
                                'value' => $cadet->unit->contact ?? 'Not specified'
                            ]
                        ] as $item)
                        <div class="px-8 py-5 flex items-start gap-5 hover:bg-gray-50/80 transition-colors group">
                            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center flex-shrink-0 border border-gray-100 text-gray-400 shadow-sm group-hover:text-cyan-600 group-hover:border-cyan-100 transition-colors">
                                <i class="fa-solid {{ $item['icon'] }} text-lg"></i>
                            </div>
                            <div class="pt-0.5">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $item['label'] }}</p>
                                <p class="text-base font-bold text-gray-800 mt-1 max-w-[200px] truncate" title="{{ $item['value'] }}">{{ $item['value'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Unit Members --}}
        <div class="lg:col-span-3 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-xl">Unit Members</h3>
                        <p class="text-sm text-gray-500 font-medium">Other cadets currently enrolled in this unit</p>
                    </div>
                </div>

                @php $members = $cadet->unit->cadets()->with('user')->where('status','approved')->get(); @endphp

                <div class="p-0">
                    @if($members->isEmpty())
                    <div class="p-16 text-center bg-white">
                        <div class="w-20 h-20 rounded-2xl bg-gray-50 border border-gray-100 text-gray-300 flex items-center justify-center mx-auto mb-5 text-3xl shadow-sm">
                            <i class="fa-solid fa-user-slash"></i>
                        </div>
                        <p class="text-gray-500 font-medium text-base">No other members found in this unit.</p>
                    </div>
                    @else
                    <ul class="divide-y divide-gray-50">
                        @foreach($members as $member)
                        <li class="px-8 py-5 flex items-center justify-between hover:bg-gray-50/50 transition-colors group">
                            <div class="flex items-center gap-5">
                                <!-- Dynamic Avatar Color based on name -->
                                @php 
                                    $hash = abs(crc32($member->user?->name ?? 'X'));
                                    $hue = $hash % 360;
                                @endphp
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-extrabold text-lg shadow-sm group-hover:scale-105 transition-transform" style="background-color: hsl({{ $hue }}, 65%, 45%)">
                                    {{ strtoupper(substr($member->user?->name ?? 'X', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-base font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $member->user?->name ?? '—' }}</p>
                                    <p class="text-xs text-gray-500 font-bold tracking-widest mt-0.5">{{ $member->enrollment_no }} &bull; {{ $member->rank ?? 'Cadet' }}</p>
                                </div>
                            </div>
                            
                            @if($member->id === $cadet->id)
                            <span class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-green-200 shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span> You
                            </span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

@else
<!-- Empty State if No Unit Assigned -->
<div class="max-w-3xl mx-auto mt-12 bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center relative overflow-hidden transition-all duration-300 hover:shadow-xl">
    <div class="absolute inset-0 bg-blue-50/20"></div>
    <div class="relative z-10 w-28 h-28 mx-auto bg-white rounded-3xl flex items-center justify-center mb-8 shadow-sm border border-gray-100">
        <i class="fa-solid fa-shield-cat text-5xl text-gray-300"></i>
    </div>
    <h2 class="text-3xl font-extrabold text-gray-800 mb-3 relative z-10">No Unit Assigned</h2>
    <p class="text-gray-500 mb-10 text-lg max-w-md mx-auto relative z-10 font-medium leading-relaxed">You have not been assigned to a unit yet by the administration. Please contact your NCC officer for placement.</p>
    <a href="{{ route('cadet.dashboard') }}" class="relative z-10 inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white bg-blue-600 rounded-xl shrink-0 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all shadow-lg shadow-blue-500/30">
        <i class="fa-solid fa-arrow-left mr-3"></i> Return to Dashboard
    </a>
</div>
@endif

@endsection
