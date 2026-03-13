@extends('layouts.cadet-new')
@section('title', 'Leave Requests')
@section('page-title', 'Leave Requests')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        
        <!-- Left Column: Leave History -->
        <div class="lg:col-span-3 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-inner">
                        <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-xl">Leave History</h3>
                        <p class="text-sm text-gray-500 font-medium">All your submitted leave requests and their status</p>
                    </div>
                </div>

                <div class="p-0">
                    @if($leaves->isEmpty())
                    <div class="p-16 text-center bg-white">
                        <div class="w-20 h-20 rounded-2xl bg-gray-50 border border-gray-100 text-gray-300 flex items-center justify-center mx-auto mb-5 text-3xl shadow-sm">
                            <i class="fa-regular fa-folder-open"></i>
                        </div>
                        <p class="text-gray-500 font-medium text-base">No leave requests submitted yet.</p>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/80 text-gray-400 text-xs font-bold uppercase tracking-widest border-b border-gray-100">
                                    <th class="px-8 py-5">Reason</th>
                                    <th class="px-8 py-5">From &bull; To</th>
                                    <th class="px-8 py-5">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 bg-white text-sm">
                                @foreach($leaves as $leave)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-8 py-5 text-gray-800 font-bold max-w-[250px] truncate group-hover:text-blue-600 transition-colors" title="{{ $leave->reason }}">
                                        {{ Str::limit($leave->reason, 50) }}
                                    </td>
                                    <td class="px-8 py-5 text-gray-500 font-medium whitespace-nowrap">
                                        {{ $leave->from_date->format('d M Y') }} &mdash; {{ $leave->to_date->format('d M Y') }}
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        @if($leave->status === 'approved')
                                        <span class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-green-200 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Approved
                                        </span>
                                        @elseif($leave->status === 'rejected')
                                        <span class="inline-flex items-center gap-2 bg-red-50 text-red-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-red-200 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-red-500"></span> Rejected
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-2 bg-yellow-50 text-yellow-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-yellow-200 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span> Pending
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

        <!-- Right Column: Apply Form -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-28 transition-all duration-300 hover:shadow-xl">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner">
                        <i class="fa-solid fa-plus text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-xl">Apply for Leave</h3>
                        <p class="text-sm text-gray-500 font-medium">Submit a new leave request</p>
                    </div>
                </div>

                <div class="p-8">
                    @if($errors->any())
                    <div class="mb-6 bg-red-50 text-red-700 p-5 rounded-xl flex items-start gap-4 border border-red-200 text-sm shadow-sm font-medium">
                        <i class="fa-solid fa-circle-exclamation mt-0.5 text-lg"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('cadet.leave.store') }}" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block">From Date</label>
                                <input type="date" name="from_date" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 shadow-sm" value="{{ old('from_date') }}" required min="{{ date('Y-m-d') }}">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block">To Date</label>
                                <input type="date" name="to_date" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm font-bold rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 transition-colors duration-200 shadow-sm" value="{{ old('to_date') }}" required min="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-gray-500 uppercase tracking-widest block">Reason</label>
                            <textarea name="reason" rows="4" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm font-medium rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-4 transition-colors duration-200 resize-y min-h-[120px] shadow-sm" placeholder="Explain the reason for leave in detail..." required>{{ old('reason') }}</textarea>
                        </div>

                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-bold rounded-xl text-base px-5 py-4 text-center flex justify-center items-center gap-3 transition-colors shadow-lg shadow-blue-500/30">
                            <i class="fa-solid fa-paper-plane"></i> Submit Leave Request
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
