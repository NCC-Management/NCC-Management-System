@extends('layouts.cadet-new')
@section('title', 'Certificates & Awards')
@section('page-title', 'Certificates & Awards')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- B Certificate -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group flex flex-col">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-600"></div>
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 shadow-inner group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-medal text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">B Certificate</h3>
            <p class="text-sm text-gray-500 font-medium mb-8 flex-1">Awarded after successful completion of 2-year NCC training and annual camp participation.</p>
            
            <div class="flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-2 bg-yellow-50 text-yellow-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-yellow-200">
                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span> Not Yet Awarded
                </span>
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-400 rounded-xl text-sm font-bold cursor-not-allowed border border-gray-200 transition-colors">
                    <i class="fa-solid fa-download"></i> PDF
                </span>
            </div>
        </div>

        <!-- C Certificate -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group flex flex-col">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-purple-600"></div>
            <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center mb-6 shadow-inner group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-medal text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">C Certificate</h3>
            <p class="text-sm text-gray-500 font-medium mb-8 flex-1">Senior Division / Senior Wing certificate for 3-year cadets who have passed the written and practical examination.</p>
            
            <div class="flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-2 bg-yellow-50 text-yellow-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-yellow-200">
                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span> Not Yet Awarded
                </span>
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-400 rounded-xl text-sm font-bold cursor-not-allowed border border-gray-200 transition-colors">
                    <i class="fa-solid fa-download"></i> PDF
                </span>
            </div>
        </div>

        <!-- Best Cadet -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden group flex flex-col">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-amber-500"></div>
            <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center mb-6 shadow-inner group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-trophy text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Best Cadet Award</h3>
            <p class="text-sm text-gray-500 font-medium mb-8 flex-1">Awarded to the outstanding cadet of the year based on attendance, performance, and discipline.</p>
            
            <div class="flex items-center justify-between mt-auto">
                <span class="inline-flex items-center gap-2 bg-yellow-50 text-yellow-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-yellow-200">
                    <span class="w-2 h-2 rounded-full bg-yellow-500"></span> Not Yet Awarded
                </span>
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-400 rounded-xl text-sm font-bold cursor-not-allowed border border-gray-200 transition-colors">
                    <i class="fa-solid fa-download"></i> PDF
                </span>
            </div>
        </div>

    </div>

    <!-- Awards Panel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shadow-inner">
                <i class="fa-solid fa-award text-lg"></i>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-lg">Awards & Recognitions</h3>
                <p class="text-sm text-gray-500 font-medium">Medals, trophies, and special recognitions received during your NCC tenure</p>
            </div>
        </div>
        <div class="p-10 text-center bg-gray-50/30 m-8 rounded-2xl border-2 border-dashed border-gray-200">
            <div class="w-20 h-20 rounded-2xl bg-white shadow-sm border border-gray-100 text-gray-300 flex items-center justify-center mx-auto mb-5 text-4xl">
                <i class="fa-solid fa-star"></i>
            </div>
            <p class="text-gray-500 font-medium text-base">No awards recorded yet.<br>Awards will appear here once added by your officer.</p>
        </div>
    </div>

</div>

@endsection
