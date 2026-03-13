@extends('layouts.cadet-new')
@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')

<div class="max-w-4xl mx-auto space-y-8">

    @if($notifications->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center w-full transition-all duration-300 hover:shadow-xl">
        <div class="w-24 h-24 rounded-3xl bg-blue-50 text-blue-400 flex items-center justify-center mx-auto mb-8 text-4xl shadow-inner">
            <i class="fa-regular fa-bell-slash"></i>
        </div>
        <h3 class="text-2xl font-extrabold text-gray-800 mb-3">You're all caught up!</h3>
        <p class="text-gray-500 text-base font-medium max-w-md mx-auto leading-relaxed">No notifications at this time. When you receive updates about events, leave, or training, they will appear here.</p>
    </div>
    @else
    
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-extrabold text-gray-800">Recent Notifications</h2>
        <span class="inline-flex items-center justify-center px-4 py-1.5 text-sm font-bold text-gray-600 bg-white rounded-xl border border-gray-200 shadow-sm">
            {{ $notifications->count() }} Notification{{ $notifications->count() !== 1 ? 's' : '' }}
        </span>
    </div>

    <div class="space-y-5">
        @foreach($notifications as $notif)
        @php
            // Define styling colors and icons per type
            $typeStyles = [
                'general'  => ['color' => 'blue',   'icon' => 'fa-bell'],
                'event'    => ['color' => 'amber',  'icon' => 'fa-calendar-check'],
                'leave'    => ['color' => 'green',  'icon' => 'fa-file-contract'],
                'training' => ['color' => 'purple', 'icon' => 'fa-bullseye'],
            ];
            $style = $typeStyles[$notif->type] ?? $typeStyles['general'];
            $c = $style['color'];
        @endphp
        
        <div class="group flex items-start gap-5 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:border-gray-300 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden {{ !$notif->is_read ? 'ring-2 ring-blue-500/20' : '' }}">
            
            <!-- Left border accent for unread -->
            @if(!$notif->is_read)
            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-600"></div>
            @endif

            <!-- Icon -->
            <div class="flex-shrink-0 w-14 h-14 rounded-2xl flex items-center justify-center bg-{{ $c }}-50 text-{{ $c }}-600 group-hover:scale-110 transition-transform shadow-inner">
                <i class="fa-solid {{ $style['icon'] }} text-2xl"></i>
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0 pr-6 pt-1">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="text-base font-extrabold text-gray-900 truncate pr-4 {{ !$notif->is_read ? 'text-blue-900' : '' }}">{{ $notif->title }}</h4>
                    <!-- 'Unread' dot -->
                    @if(!$notif->is_read)
                    <div class="flex-shrink-0 w-3 h-3 bg-blue-500 rounded-full shadow-[0_0_0_4px_rgba(59,130,246,0.15)] mt-1.5 animate-pulse"></div>
                    @endif
                </div>
                <p class="text-sm text-gray-600 font-medium leading-relaxed mb-4">{{ $notif->message }}</p>
                
                <div class="flex items-center gap-3 text-xs text-gray-400 font-bold tracking-widest uppercase">
                    <span class="flex items-center gap-1.5">
                        <i class="fa-regular fa-clock text-gray-300"></i>
                        {{ $notif->created_at->diffForHumans() }}
                    </span>
                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                    <span class="text-{{ $c }}-600 bg-{{ $c }}-50 px-2 py-0.5 rounded-md">{{ ucfirst($notif->type) }}</span>
                </div>
            </div>
            
        </div>
        @endforeach
    </div>
    
    @endif

</div>

@endsection
