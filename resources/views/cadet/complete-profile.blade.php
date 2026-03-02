<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complete Profile | NCC Portal</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        theme: {
                            green: '#2c5243',   /* Core Brand Green */
                            black: '#0a0a0a',   /* True Black */
                            border: '#e5e7eb',  /* Soft Gray for borders */
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f4f5; }
        .font-playfair { font-family: 'Playfair Display', serif; }
        
        /* Custom styles for select dropdown arrow */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }

        /* Smooth Entrance Animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 lg:p-8 relative overflow-x-hidden">

    <div class="fixed top-[-10%] left-[-10%] w-[500px] h-[500px] bg-theme-green opacity-[0.03] rounded-full blur-[100px] pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-gray-400 opacity-[0.05] rounded-full blur-[120px] pointer-events-none"></div>

    <div class="bg-white shadow-[0_20px_50px_-15px_rgba(0,0,0,0.1)] border border-white rounded-[2.5rem] p-8 lg:p-12 w-full max-w-4xl relative z-10 animate-fade-up">

        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-theme-black text-white rounded-2xl flex items-center justify-center font-extrabold text-2xl mx-auto mb-6 shadow-lg shadow-gray-200">
                N
            </div>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-theme-black tracking-tight mb-3">
                Complete Your <span class="font-playfair italic text-theme-green font-semibold">Profile</span>
            </h2>
            <p class="text-gray-500 font-medium">Please provide the final details to activate your cadet account.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-100 rounded-2xl p-5 mb-8 flex gap-4 items-start shadow-sm">
                <div class="bg-red-100 text-red-600 rounded-full p-1.5 shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-red-800 font-extrabold text-sm mb-1">Please correct the following errors:</h4>
                    <ul class="list-disc pl-4 text-sm text-red-600 font-medium space-y-1 marker:text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('cadet.complete-profile.store') }}" class="space-y-8">
            @csrf

            <div class="bg-gray-50 border border-theme-border rounded-[1.5rem] p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-[inset_0_2px_4px_rgba(0,0,0,0.02)]">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-400 shadow-sm shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-extrabold text-theme-green uppercase tracking-widest mb-0.5">System Locked</p>
                        <p class="text-sm font-extrabold text-theme-black">Enrollment Number</p>
                    </div>
                </div>
                <input type="hidden" name="enrollment_no" value="{{ auth()->user()->cadet->enrollment_no ?? 'NCC/2026/0000' }}">
                <div class="bg-white border border-gray-200 px-5 py-3 rounded-xl text-gray-800 font-bold font-mono tracking-wide shadow-sm flex items-center justify-center sm:min-w-[200px]">
                    {{ auth()->user()->cadet->enrollment_no ?? 'NCC/2026/0000' }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-xs font-extrabold text-theme-black uppercase tracking-wide mb-2 pl-1">Student ID <span class="text-red-500">*</span></label>
                    <input type="text" name="student_id" placeholder="e.g. 2024BCS001"
                        value="{{ old('student_id') }}"
                        class="w-full px-5 py-4 bg-gray-50/50 border border-theme-border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-semibold text-theme-black placeholder-gray-400" required>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-theme-black uppercase tracking-wide mb-2 pl-1">Degree / Course <span class="text-red-500">*</span></label>
                    <input type="text" name="course" placeholder="e.g. B.Sc Computer Science"
                        value="{{ old('course') }}"
                        class="w-full px-5 py-4 bg-gray-50/50 border border-theme-border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-semibold text-theme-black placeholder-gray-400" required>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-theme-black uppercase tracking-wide mb-2 pl-1">Phone Number <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-500 font-bold">+91</span>
                        <input type="tel" name="phone" placeholder="98765 43210"
                            value="{{ old('phone') }}"
                            class="w-full pl-14 pr-5 py-4 bg-gray-50/50 border border-theme-border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-semibold text-theme-black placeholder-gray-400" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-theme-black uppercase tracking-wide mb-2 pl-1">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="dob"
                        value="{{ old('dob') }}"
                        class="w-full px-5 py-4 bg-gray-50/50 border border-theme-border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-semibold text-theme-black placeholder-gray-400 cursor-pointer text-gray-700" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-extrabold text-theme-black uppercase tracking-wide mb-2 pl-1">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" class="w-full px-5 py-4 bg-gray-50/50 border border-theme-border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-semibold text-theme-black cursor-pointer" required>
                        <option value="" disabled {{ old('gender') ? '' : 'selected' }} class="text-gray-400">Select your gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-extrabold text-theme-black uppercase tracking-wide mb-2 pl-1">Full Address <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="3" placeholder="Enter your complete residential address..."
                        class="w-full px-5 py-4 bg-gray-50/50 border border-theme-border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-semibold text-theme-black placeholder-gray-400 resize-none" required>{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <p class="text-xs text-gray-400 font-medium hidden sm:block">Please verify all details before submitting.</p>
                <button type="submit"
                    class="w-full sm:w-auto bg-theme-black text-white px-10 py-4 rounded-2xl font-extrabold shadow-[0_10px_20px_-10px_rgba(10,10,10,0.5)] hover:bg-theme-green hover:shadow-[0_10px_25px_-10px_rgba(44,82,67,0.6)] hover:-translate-y-0.5 transition-all duration-300">
                    Save & Activate Account
                </button>
            </div>

        </form>
    </div>

</body>
</html>