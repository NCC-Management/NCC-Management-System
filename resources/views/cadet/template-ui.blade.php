<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadet Dashboard - NCC Management System</title>
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
</head>
<body class="bg-gray-50 font-sans text-gray-800 flex h-screen overflow-hidden selection:bg-blue-200 selection:text-blue-900">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <!-- LARAVEL TIP: Extract this aside element into resources/views/components/sidebar.blade.php -->
    <aside id="sidebar" class="bg-ncc-navy text-gray-300 w-64 flex-shrink-0 flex flex-col transition-transform transform -translate-x-full lg:translate-x-0 fixed lg:relative z-30 h-full">
        <!-- Logo Area -->
        <div class="h-16 flex items-center px-6 bg-slate-900 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <!-- Mock NCC Logo Icon -->
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
                <img src="https://ui-avatars.com/api/?name=Rahul+Kumar&background=0D8ABC&color=fff" alt="Cadet Profile" class="w-12 h-12 rounded-full border-2 border-slate-600">
                <div>
                    <h3 class="text-white font-semibold text-sm">SUO Rahul Kumar</h3>
                    <p class="text-xs text-slate-400">IND/SD/21/123456</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Main Menu</p>
            
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 bg-blue-600 text-white rounded-lg group">
                <i class="fa-solid fa-table-columns w-5 text-center"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
                <i class="fa-regular fa-id-badge w-5 text-center text-slate-400 group-hover:text-white transition-colors"></i>
                <span class="font-medium text-sm">My Profile</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
                <i class="fa-regular fa-calendar-check w-5 text-center text-slate-400 group-hover:text-white transition-colors"></i>
                <span class="font-medium text-sm">Attendance</span>
                <span class="ml-auto bg-slate-700 text-xs py-0.5 px-2 rounded-full text-white">85%</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
                <i class="fa-solid fa-tents w-5 text-center text-slate-400 group-hover:text-white transition-colors"></i>
                <span class="font-medium text-sm">Camps & Events</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
                <i class="fa-solid fa-medal w-5 text-center text-slate-400 group-hover:text-white transition-colors"></i>
                <span class="font-medium text-sm">Achievements</span>
            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2.5 hover:bg-slate-800 hover:text-white rounded-lg transition-colors group">
                <i class="fa-solid fa-file-contract w-5 text-center text-slate-400 group-hover:text-white transition-colors"></i>
                <span class="font-medium text-sm">Exams (B & C Cert)</span>
            </a>
        </nav>

        <!-- Settings & Logout -->
        <div class="p-4 border-t border-slate-800 space-y-1">
            <a href="#" class="flex items-center gap-3 px-3 py-2 hover:bg-slate-800 hover:text-white rounded-lg transition-colors text-sm">
                <i class="fa-solid fa-gear w-5 text-center text-slate-400"></i>
                <span>Settings</span>
            </a>
            <!-- LARAVEL TIP: Use a form with POST method for logout -->
            <a href="#" class="flex items-center gap-3 px-3 py-2 hover:bg-red-500 hover:text-white text-red-400 rounded-lg transition-colors text-sm">
                <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 bg-gray-50">
        
        <!-- Header -->
        <!-- LARAVEL TIP: Extract this header into resources/views/components/header.blade.php -->
        <header class="h-16 bg-white shadow-sm border-b border-gray-200 flex items-center justify-between px-4 lg:px-8 z-10">
            <div class="flex items-center gap-4">
                <button class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-800 hidden sm:block">Cadet Portal</h1>
            </div>

            <div class="flex items-center gap-5">
                <!-- Search -->
                <div class="hidden md:flex relative">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search notices, camps..." class="pl-10 pr-4 py-2 bg-gray-100 border-transparent rounded-full text-sm focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all w-64 outline-none">
                </div>

                <!-- Notifications -->
                <button class="relative text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center border-2 border-white">3</span>
                </button>

                <!-- Profile Dropdown Trigger -->
                <div class="relative cursor-pointer flex items-center gap-2" onclick="toggleProfileMenu()">
                    <img src="https://ui-avatars.com/api/?name=Rahul+Kumar&background=0D8ABC&color=fff" alt="User" class="w-9 h-9 rounded-full border border-gray-200 object-cover">
                    <i class="fa-solid fa-chevron-down text-xs text-gray-500"></i>
                    
                    <!-- Dropdown Menu -->
                    <div id="profileMenu" class="hidden absolute right-0 top-12 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-regular fa-user mr-2"></i> Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"><i class="fa-solid fa-shield-halved mr-2"></i> Unit Details</a>
                        <hr class="my-1 border-gray-100">
                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="fa-solid fa-power-off mr-2"></i> Logout</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <!-- LARAVEL TIP: This is where your @yield('content') would go in the master layout -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-700 to-ncc-navy rounded-2xl p-6 lg:p-8 text-white shadow-md mb-8 relative overflow-hidden">
                <!-- Decorative SVG -->
                <svg class="absolute right-0 top-0 h-full w-1/2 text-white/10 transform translate-x-1/4" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl lg:text-3xl font-bold mb-1">Jai Hind, SUO Rahul Kumar! 🇮🇳</h2>
                        <p class="text-blue-100 text-sm lg:text-base">1 Delhi Armd Sqn NCC | Directorate: Delhi</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-3 border border-white/30 text-center">
                        <p class="text-xs text-blue-100 uppercase tracking-wider mb-1">Next Parade</p>
                        <p class="font-bold text-lg">Sunday, 0800 HRS</p>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                        <i class="fa-solid fa-person-military-pointing text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Parade Attendance</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl font-bold text-gray-800">85%</h3>
                            <span class="text-xs text-green-500 font-medium mb-1">+2% this month</span>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                        <i class="fa-solid fa-campground text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Camps Attended</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl font-bold text-gray-800">02</h3>
                            <span class="text-xs text-gray-400 font-medium mb-1">ATC, CATC</span>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                        <i class="fa-solid fa-bullseye text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Weapon Firing</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl font-bold text-gray-800">42/50</h3>
                            <span class="text-xs text-purple-500 font-medium mb-1">Grade A</span>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 flex-shrink-0">
                        <i class="fa-solid fa-star text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Social Service</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-2xl font-bold text-gray-800">14</h3>
                            <span class="text-xs text-gray-400 font-medium mb-1">Hours Logged</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid (2 Columns) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Announcements & Upcoming (Spans 2 cols on large screens) -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Notice Board -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                            <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-bullhorn text-blue-600"></i> Unit Announcements
                            </h3>
                            <a href="#" class="text-sm text-blue-600 hover:underline font-medium">View All</a>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <!-- Notice Item -->
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-semibold text-gray-800">Selection for Republic Day Camp (RDC) 2027</h4>
                                    <span class="inline-block bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-medium border border-red-200">Urgent</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-3">All eligible cadets aspiring for RDC are directed to report to the Unit HQ on Friday at 0900 HRS in proper working rig.</p>
                                <div class="flex items-center gap-4 text-xs text-gray-400">
                                    <span><i class="fa-regular fa-calendar mr-1"></i> Posted: Oct 12, 2026</span>
                                    <span><i class="fa-solid fa-user-pen mr-1"></i> By: ANO Capt. Sharma</span>
                                </div>
                            </div>
                            <!-- Notice Item -->
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-semibold text-gray-800">Submission of 'C' Certificate Forms</h4>
                                </div>
                                <p class="text-sm text-gray-600 mb-3">The last date for submitting the 'C' certificate examination forms has been extended to Oct 20. Ensure all documents are attested.</p>
                                <div class="flex items-center gap-4 text-xs text-gray-400">
                                    <span><i class="fa-regular fa-calendar mr-1"></i> Posted: Oct 10, 2026</span>
                                    <span><i class="fa-solid fa-user-pen mr-1"></i> By: Unit Clerk</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Schedule -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                                <i class="fa-regular fa-calendar-days text-blue-600"></i> Upcoming Schedule
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="relative border-l-2 border-gray-200 ml-3 space-y-6">
                                <!-- Timeline Item -->
                                <div class="relative pl-6">
                                    <div class="absolute w-3 h-3 bg-blue-600 rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                                    <p class="text-xs text-blue-600 font-bold mb-1">Sunday, 15 Oct 2026 • 0800 - 1200 HRS</p>
                                    <h4 class="font-semibold text-gray-800">Regular Sunday Parade</h4>
                                    <p class="text-sm text-gray-500 mt-1">Location: College Ground. Uniform: Khaki.</p>
                                </div>
                                <!-- Timeline Item -->
                                <div class="relative pl-6">
                                    <div class="absolute w-3 h-3 bg-gray-300 rounded-full -left-[7px] top-1.5 ring-4 ring-white"></div>
                                    <p class="text-xs text-gray-500 font-bold mb-1">20 Oct - 25 Oct 2026</p>
                                    <h4 class="font-semibold text-gray-800">Blood Donation Camp Duty</h4>
                                    <p class="text-sm text-gray-500 mt-1">Location: City Hospital. Volunteer duty roster updated.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Profile Completion & Quick Links -->
                <div class="space-y-8">
                    
                    <!-- Profile Status -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-semibold text-gray-800 mb-4">Profile Completion</h3>
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-gray-600">Overall Progress</span>
                            <span class="font-bold text-gray-800">90%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 90%"></div>
                        </div>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-center text-green-600">
                                <i class="fa-solid fa-circle-check mr-2"></i> Personal Details
                            </li>
                            <li class="flex items-center text-green-600">
                                <i class="fa-solid fa-circle-check mr-2"></i> Medical Records
                            </li>
                            <li class="flex items-center text-orange-500">
                                <i class="fa-solid fa-circle-exclamation mr-2"></i> Bank Passbook Upload
                            </li>
                        </ul>
                        <button class="mt-5 w-full py-2 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors">
                            Update Profile
                        </button>
                    </div>

                    <!-- Resource Links -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-semibold text-gray-800 mb-4">Study Material</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors border border-transparent hover:border-blue-100 group">
                                <i class="fa-solid fa-book-open text-gray-400 group-hover:text-blue-500 text-2xl mb-2"></i>
                                <span class="text-xs font-medium text-gray-600 group-hover:text-blue-600">Common Sub</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors border border-transparent hover:border-blue-100 group">
                                <i class="fa-solid fa-jet-fighter-up text-gray-400 group-hover:text-blue-500 text-2xl mb-2"></i>
                                <span class="text-xs font-medium text-gray-600 group-hover:text-blue-600">Special Sub</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors border border-transparent hover:border-blue-100 group">
                                <i class="fa-solid fa-file-pdf text-gray-400 group-hover:text-blue-500 text-2xl mb-2"></i>
                                <span class="text-xs font-medium text-gray-600 group-hover:text-blue-600">Prev Papers</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center p-4 bg-gray-50 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors border border-transparent hover:border-blue-100 group">
                                <i class="fa-solid fa-video text-gray-400 group-hover:text-blue-500 text-2xl mb-2"></i>
                                <span class="text-xs font-medium text-gray-600 group-hover:text-blue-600">Drill Videos</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-10 pt-6 border-t border-gray-200 text-center text-sm text-gray-500">
                &copy; 2026 National Cadet Corps Management System. Designed for structural discipline.
            </footer>

        </main>
    </div>

    <!-- Basic Script for interactivity -->
    <script>
        // Toggle Sidebar on Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
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
</body>
</html>