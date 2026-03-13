@extends('layouts.cadet-new')
@section('title', 'Training & Performance')
@section('page-title', 'Training & Performance')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-400 to-blue-600 opacity-90"></div>
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-inner border border-blue-100/50">
                    <i class="fa-solid fa-person-running text-2xl"></i>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Score</p>
                    <span class="text-3xl font-black text-gray-800 leading-none block">N/A</span>
                </div>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 text-lg tracking-tight mb-1">Physical Test</h3>
                <p class="text-sm text-gray-500 font-medium mb-4">Running, push-ups, sit-ups.</p>
                <div class="w-full bg-blue-50 rounded-full h-2 border border-blue-100/50 overflow-hidden">
                    <div class="bg-blue-500 h-full rounded-full shadow-sm" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-amber-400 to-amber-600 opacity-90"></div>
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-inner border border-amber-100/50">
                    <i class="fa-solid fa-shoe-prints text-2xl"></i>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Score</p>
                    <span class="text-3xl font-black text-gray-800 leading-none block">N/A</span>
                </div>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 text-lg tracking-tight mb-1">Drill Performance</h3>
                <p class="text-sm text-gray-500 font-medium mb-4">March-past, parade discipline.</p>
                <div class="w-full bg-amber-50 rounded-full h-2 border border-amber-100/50 overflow-hidden">
                    <div class="bg-amber-500 h-full rounded-full shadow-sm" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-purple-400 to-purple-600 opacity-90"></div>
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-inner border border-purple-100/50">
                    <i class="fa-solid fa-file-pen text-2xl"></i>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Marks</p>
                    <span class="text-3xl font-black text-gray-800 leading-none block">N/A</span>
                </div>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 text-lg tracking-tight mb-1">Written Test</h3>
                <p class="text-sm text-gray-500 font-medium mb-4">Theory, history, regulations.</p>
                <div class="w-full bg-purple-50 rounded-full h-2 border border-purple-100/50 overflow-hidden">
                    <div class="bg-purple-500 h-full rounded-full shadow-sm" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50/80 rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-cyan-400 to-cyan-600 opacity-90"></div>
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-500 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform shadow-inner border border-cyan-100/50">
                    <i class="fa-solid fa-tents text-2xl"></i>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1.5">Grade</p>
                    <span class="text-3xl font-black text-gray-800 leading-none block">N/A</span>
                </div>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 text-lg tracking-tight mb-1">Camp Performance</h3>
                <p class="text-sm text-gray-500 font-medium mb-4">Annual Training Camp overall.</p>
                <div class="w-full bg-cyan-50 rounded-full h-2 border border-cyan-100/50 overflow-hidden">
                    <div class="bg-cyan-500 h-full rounded-full shadow-sm" style="width: 0%"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Promotion Eligibility Banner -->
    <div class="bg-white border border-gray-100 rounded-2xl p-8 flex flex-col sm:flex-row items-start sm:items-center gap-6 shadow-sm transition-all duration-300 hover:shadow-xl">
        <div class="w-16 h-16 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0 shadow-inner">
            <i class="fa-solid fa-ranking-star text-2xl"></i>
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold text-gray-800 mb-1">Promotion Eligibility</h3>
            <p class="text-sm text-gray-500 font-medium">Scores and promotion eligibility are updated by your unit officer after each training cycle. Check back after your next camp.</p>
        </div>
        <div class="flex-shrink-0 mt-4 sm:mt-0">
            <span class="inline-flex items-center gap-2 bg-yellow-50 text-yellow-700 px-4 py-2 rounded-xl text-sm font-bold border border-yellow-200">
                <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span> Pending Data
            </span>
        </div>
    </div>

</div>

@endsection
