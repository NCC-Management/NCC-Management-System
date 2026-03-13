<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadet Portal - @yield('title', 'Dashboard')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        ncc: {
                            navy: '#0f172a', // Deep navy for professional uniform feel
                            red: '#dc2626',
                            lightBlue: '#38bdf8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar for a cleaner look */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans text-gray-800 flex h-screen overflow-hidden selection:bg-blue-200 selection:text-blue-900">

    @php 
        $cadetUser = auth()->user(); 
        $cadetRec = $cadetUser->cadet; 
        $seg = request()->segment(2); // for active link checks

        $unreadCount = 0;
        $sidebarAttendancePct = $attendancePct ?? 0;

        if ($cadetRec && $cadetRec->isApproved()) {
            $unreadCount = \App\Models\CadetNotification::where(function($q) use($cadetRec){
                $q->where('cadet_id', $cadetRec->id)->orWhereNull('cadet_id');
            })->where('is_read', false)->count();

            if (!isset($attendancePct)) {
                $totalEv = \App\Models\Event::count();
                $attEv = \App\Models\Attendance::where('cadet_id', $cadetRec->id)->where('status', 'present')->count();
                $sidebarAttendancePct = $totalEv > 0 ? round(($attEv / $totalEv) * 100) : 0;
            }
        }
    @endphp

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="bg-ncc-navy text-gray-300 w-64 flex-shrink-0 flex flex-col transition-transform transform -translate-x-full lg:translate-x-0 fixed lg:relative z-30 h-full">
        <!-- Logo Area -->
        <div class="h-16 flex items-center px-6 bg-slate-900 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-ncc-navy font-bold shadow-md">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <span class="text-white font-bold text-lg tracking-wide">NCC Admin</span>
            </div>
            <button class="ml-auto lg:hidden text-gray-400 hover:text-white" onclick="toggleSidebar()">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>

        <!-- Cadet Info Summary -->
        <div class="p-6 border-b border-slate-800">
            <div class="flex items-center gap-4">
                @if($cadetUser->profile_photo)
                    <img src="{{ asset('storage/' . $cadetUser->profile_photo) }}" alt="Cadet Profile" class="w-12 h-12 rounded-full border-2 border-slate-600 object-cover">
                @else
                    <div class="w-12 h-12 rounded-full border-2 border-slate-600 flex items-center justify-center text-white font-bold bg-gradient-to-br from-blue-500 to-blue-600 shadow-inner">
                        {{ strtoupper(substr($cadetUser->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h3 class="text-white font-semibold text-sm">{{ $cadetUser->name }}</h3>
                    <p class="text-xs text-slate-400">{{ $cadetRec->enrollment_no ?? 'Pending Enrollment' }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Main Menu</p>
            
            <a href="{{ route('cadet.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 {{ $seg === 'dashboard' || $seg === '' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white text-slate-400' }} rounded-lg transition-colors group">
                <i class="fa-solid fa-table-columns w-5 text-center {{ $seg === 'dashboard' || $seg === '' ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
            
            @if($cadetRec && $cadetRec->isApproved())
            <a href="{{ route('cadet.profile') }}" class="flex items-center gap-3 px-3 py-2.5 {{ $seg === 'profile' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white text-slate-400' }} rounded-lg transition-colors group">
                <i class="fa-regular fa-id-badge w-5 text-center {{ $seg === 'profile' ? 'text-white' : 'text-slate-400 group-hover:text-white' }} transition-colors"></i>
                <span class="font-medium text-sm">My Profile</span>
            </a>

            <a href="{{ route('cadet.attendance') }}" class="flex items-center gap-3 px-3 py-2.5 {{ $seg === 'attendance' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white text-slate-400' }} rounded-lg transition-colors group">
                <i class="fa-regular fa-calendar-check w-5 text-center {{ $seg === 'attendance' ? 'text-white' : 'text-slate-400 group-hover:text-white' }} transition-colors"></i>
                <span class="font-medium text-sm">Attendance</span>
                <span class="ml-auto bg-slate-700 text-xs py-0.5 px-2 rounded-full text-white">{{ $sidebarAttendancePct }}%</span>
            </a>

            <a href="{{ route('cadet.events') }}" class="flex items-center gap-3 px-3 py-2.5 {{ $seg === 'events' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white text-slate-400' }} rounded-lg transition-colors group">
                <i class="fa-solid fa-tents w-5 text-center {{ $seg === 'events' ? 'text-white' : 'text-slate-400 group-hover:text-white' }} transition-colors"></i>
                <span class="font-medium text-sm">Camps & Events</span>
            </a>
            
            <a href="{{ route('cadet.unit') }}" class="flex items-center gap-3 px-3 py-2.5 {{ $seg === 'unit' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white text-slate-400' }} rounded-lg transition-colors group">
                <i class="fa-solid fa-shield-halved w-5 text-center {{ $seg === 'unit' ? 'text-white' : 'text-slate-400 group-hover:text-white' }} transition-colors"></i>
                <span class="font-medium text-sm">My Unit</span>
            </a>

            <a href="{{ route('cadet.training') }}" class="flex items-center gap-3 px-3 py-2.5 {{ $seg === 'training' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white text-slate-400' }} rounded-lg transition-colors group">
                <i class="fa-solid fa-bullseye w-5 text-center {{ $seg === 'training' ? 'text-white' : 'text-slate-400 group-hover:text-white' }} transition-colors"></i>
                <span class="font-medium text-sm">Training</span>
            </a>

            <a href="{{ route('cadet.certificates') }}" class="flex items-center gap-3 px-3 py-2.5 {{ $seg === 'certificates' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white text-slate-400' }} rounded-lg transition-colors group">
                <i class="fa-solid fa-medal w-5 text-center {{ $seg === 'certificates' ? 'text-white' : 'text-slate-400 group-hover:text-white' }} transition-colors"></i>
                <span class="font-medium text-sm">Certificates</span>
            </a>
            
            <a href="{{ route('cadet.leave') }}" class="flex items-center gap-3 px-3 py-2.5 {{ $seg === 'leave' ? 'bg-blue-600 text-white' : 'hover:bg-slate-800 hover:text-white text-slate-400' }} rounded-lg transition-colors group">
                <i class="fa-solid fa-file-contract w-5 text-center {{ $seg === 'leave' ? 'text-white' : 'text-slate-400 group-hover:text-white' }} transition-colors"></i>
                <span class="font-medium text-sm">Leaves</span>
            </a>
            @endif
        </nav>

        <!-- Settings & Logout -->
        <div class="p-4 border-t border-slate-800 space-y-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 hover:bg-slate-800 hover:text-white text-slate-400 rounded-lg transition-colors text-sm">
                <i class="fa-solid fa-house w-5 text-center"></i>
                <span>Go to Home</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 hover:bg-red-500 hover:text-white text-red-400 rounded-lg transition-colors text-sm">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 bg-gray-50">
        
        <!-- Header -->
        <header class="relative z-50 h-16 bg-white shadow-sm border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 transition-colors">
            <div class="flex items-center gap-4">
                <button class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-800 hidden sm:block">Cadet Portal</h1>
            </div>

            <div class="flex items-center gap-5">

                <!-- Notifications -->
                @if($cadetRec && $cadetRec->isApproved())
                <a href="{{ route('cadet.notifications') }}" class="relative text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fa-regular fa-bell text-xl"></i>
                    @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center border-2 border-white">{{ $unreadCount }}</span>
                    @endif
                </a>
                @endif

                <div class="relative cursor-pointer flex items-center gap-2" onclick="toggleProfileMenu()">
                    @if($cadetUser->profile_photo)
                        <img src="{{ asset('storage/' . $cadetUser->profile_photo) }}" alt="User" class="w-9 h-9 rounded-full border border-gray-200 object-cover">
                    @else
                        <div class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-white font-bold text-sm bg-gradient-to-br from-blue-500 to-blue-600 shadow-inner">
                            {{ strtoupper(substr($cadetUser->name, 0, 1)) }}
                        </div>
                    @endif
                    <i class="fa-solid fa-chevron-down text-xs text-gray-500"></i>
                    
                    <!-- Dropdown Menu -->
                    <div id="profileMenu" class="hidden absolute right-0 top-12 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                        @if($cadetRec && $cadetRec->isApproved())
                        <a href="{{ route('cadet.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-regular fa-user mr-2"></i> Profile</a>
                        <a href="{{ route('cadet.unit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-shield-halved mr-2"></i> Unit Details</a>
                        <hr class="my-1 border-gray-100">
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="fa-solid fa-power-off mr-2"></i> Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-8">
            
            @if(session('success'))
            <div class="mb-4 bg-green-50 text-green-700 p-4 rounded-lg flex items-center gap-3 border border-green-200 shadow-sm">
                <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 bg-red-50 text-red-700 p-4 rounded-lg flex items-center gap-3 border border-red-200 shadow-sm">
                <i class="fa-solid fa-xmark-circle"></i> {{ session('error') }}
            </div>
            @endif

            @yield('content')

            <!-- Footer -->
            <footer class="mt-10 pt-6 border-t border-gray-200 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} National Cadet Corps Management System. Designed for structural discipline.
            </footer>

        </main>
    </div>

    <!-- Basic Script for interactivity -->
    <script>
        // Toggle Sidebar on Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if(sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        // Toggle Profile Dropdown
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.closest('.cursor-pointer')) {
                const dropdowns = document.getElementsByClassName("absolute right-0 top-12");
                for (let i = 0; i < dropdowns.length; i++) {
                    let openDropdown = dropdowns[i];
                    if (!openDropdown.classList.contains('hidden')) {
                        openDropdown.classList.add('hidden');
                    }
                }
            }
        }
    </script>
    
    @stack('scripts')
</body>
</html>
