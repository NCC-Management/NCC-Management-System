<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>College NCC Unit | Management System</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-theme-green { background-color: #2c5243; }
        .text-theme-green { color: #2c5243; }
        .border-theme-green { border-color: #2c5243; }
        [x-cloak] { display: none !important; }
        
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
    </style>
</head>

{{-- x-data: persists modal state and determines which tab to show based on specific error types --}}
<body class="bg-gray-50 antialiased text-gray-800 relative overflow-x-hidden"
      x-data="{ 
        showAuthModal: {{ $errors->any() ? 'true' : 'false' }}, 
        isLogin: {{ ($errors->has('first_name') || $errors->has('last_name') || $errors->has('password_confirmation')) ? 'false' : 'true' }}, 
        scrolled: false, mobileMenu: false 
      }"
      @scroll.window="scrolled = (window.pageYOffset > 20)">

    <nav :class="{ 'bg-white/95 backdrop-blur-xl border-b border-gray-200 shadow-sm py-4': scrolled, 'bg-transparent py-6': !scrolled }" 
         class="fixed top-0 w-full z-50 transition-all duration-500">
        <div class="max-w-7xl mx-auto px-6 md:px-8 flex justify-between items-center">
            
            <div class="flex items-center gap-3 cursor-pointer">
                <div class="w-10 h-10 bg-gradient-to-br from-[#2c5243] to-[#1a332a] rounded-xl flex items-center justify-center text-white font-extrabold text-lg shadow-md border border-[#2c5243]/20">
                    N
                </div>
                <div class="flex flex-col">
                    <span class="font-extrabold text-xl leading-none text-gray-900 tracking-tight">College NCC</span>
                    <span class="text-[9px] text-theme-green font-bold tracking-[0.2em] uppercase mt-0.5">Unit Portal</span>
                </div>
            </div>
            
            <div :class="scrolled ? 'bg-gray-50/80 border-transparent shadow-none' : 'bg-white/60 backdrop-blur-md border-white/50 shadow-sm'" 
                 class="hidden md:flex space-x-8 border rounded-full px-8 py-3 text-sm font-semibold transition-all duration-300">
                <a href="#" class="text-gray-900 hover:text-theme-green transition-colors">Home</a>
                <a href="#why-join" class="text-gray-600 hover:text-theme-green transition-colors">Why to Join</a>
                <a href="#benefits" class="text-gray-600 hover:text-theme-green transition-colors">Benefits</a>
                <a href="#contact" class="text-gray-600 hover:text-theme-green transition-colors">Contact</a>
            </div>

            <div class="flex items-center gap-4">
                <button @click="showAuthModal = true; isLogin = true" class="hidden sm:block bg-gray-900 text-white rounded-full px-7 py-3 text-sm font-bold hover:bg-theme-green transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                    Portal Login
                </button>
                
                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 shadow-sm">
                    <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <div x-show="mobileMenu" x-cloak x-transition class="md:hidden absolute top-full left-0 w-full bg-white border-b border-gray-200 px-8 py-6 space-y-4 shadow-xl">
            <a href="#" @click="mobileMenu = false" class="block text-lg font-bold text-gray-900">Home</a>
            <a href="#why-join" @click="mobileMenu = false" class="block text-lg font-semibold text-gray-600">Why to Join</a>
            <a href="#benefits" @click="mobileMenu = false" class="block text-lg font-semibold text-gray-600">Benefits</a>
            <a href="#contact" @click="mobileMenu = false" class="block text-lg font-semibold text-gray-600">Contact</a>
            <button @click="showAuthModal = true; isLogin = true; mobileMenu = false" class="w-full mt-4 bg-gray-900 text-white rounded-xl py-4 font-bold text-center">Portal Login</button>
        </div>
    </nav>

    <header class="relative min-h-screen flex items-center overflow-hidden pt-24 pb-20">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/campus-hero1.jpg') }}" 
                 alt="College Campus" 
                 class="w-full h-full object-cover lg:object-[80%_center]"
                 onerror="this.src='https://images.unsplash.com/photo-1541339907198-e08756ebafe3?q=80&w=2000&auto=format&fit=crop'">
            
            <div class="absolute inset-0 bg-gradient-to-b from-white/95 via-white/85 to-white/40 lg:bg-gradient-to-r lg:from-white/90 lg:via-white/75 lg:to-transparent lg:via-[45%] lg:to-[75%]"></div>
            
            <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-b from-white/80 to-transparent"></div>
            <div class="absolute bottom-0 inset-x-0 h-24 bg-gradient-to-t from-gray-50 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 md:px-8 w-full mt-10 lg:mt-0">
            <div class="max-w-2xl space-y-8">
                <div class="animate-fade-in-up inline-flex items-center gap-2 border border-gray-200/80 bg-white/80 backdrop-blur-sm shadow-sm rounded-full px-5 py-2.5 text-xs font-bold text-gray-700 tracking-wide uppercase">
                    <span class="w-2.5 h-2.5 rounded-full bg-theme-green animate-pulse"></span> Educate. Innovate. Lead.
                </div>
                
                <h1 class="animate-fade-in-up delay-100 text-5xl md:text-6xl lg:text-[5rem] font-black leading-[1.1] text-gray-900 tracking-tight">
                    Turn Your Ambition <br class="hidden lg:block"> into 
                    <span class="italic font-light text-theme-green relative inline-block">Achievement
                        <svg class="absolute w-full h-3 -bottom-1 left-0 text-theme-green opacity-20" viewBox="0 0 100 20" preserveAspectRatio="none"><path d="M0,10 Q50,20 100,10" stroke="currentColor" stroke-width="4" fill="transparent"/></svg>
                    </span>
                </h1>
                
                <p class="animate-fade-in-up delay-200 text-gray-700 text-lg md:text-xl max-w-lg leading-relaxed font-medium">
                    Empowering college students with world-class discipline, leadership training, and global opportunities right here on campus.
                </p>
                
                <div class="animate-fade-in-up delay-300 flex flex-col sm:flex-row items-center gap-4 pt-4">
                    <button @click="showAuthModal = true; isLogin = false" class="w-full sm:w-auto bg-theme-green text-white rounded-full px-10 py-4 font-bold transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                        Enroll Now <span class="ml-2 font-normal">→</span>
                    </button>
                    <button @click="showAuthModal = true; isLogin = true" class="w-full sm:w-auto bg-white/90 backdrop-blur-sm text-gray-800 rounded-full px-10 py-4 font-bold border border-gray-200 hover:bg-white hover:border-gray-300 transition-all duration-300 shadow-sm hover:shadow hover:-translate-y-1 text-center">
                        Login to Portal <span class="ml-2 font-normal">→</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="hidden lg:block absolute bottom-12 right-12 z-10 animate-fade-in-up delay-400">
            <div class="bg-white/95 backdrop-blur-xl p-5 rounded-[2rem] shadow-[0_20px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 flex items-center gap-5 transition-transform duration-500 hover:-translate-y-2">
                <img src="{{ asset('images/ncc-logo.jpg') }}" 
                     alt="NCC Logo" 
                     class="h-16 w-auto object-contain" 
                     onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/e/ea/National_Cadet_Corps_Logo.png'" />
                
                <div class="border-l-2 border-gray-100 pl-5 pr-2">
                    <p class="text-sm font-extrabold text-gray-900 leading-tight uppercase tracking-wide">National Cadet Corps</p>
                    <p class="text-xs text-theme-green font-bold tracking-widest mt-1">UNITY & DISCIPLINE</p>
                </div>
            </div>
        </div>
    </header>

    <section id="why-join" class="max-w-7xl mx-auto px-6 md:px-8 pb-32 pt-20">
        <div class="bg-gradient-to-br from-[#2c5243] to-[#1a332a] rounded-[3rem] p-12 lg:p-20 text-white grid grid-cols-1 lg:grid-cols-2 gap-16 relative overflow-hidden shadow-[0_20px_50px_-12px_rgba(44,82,67,0.4)]">
            <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-white opacity-[0.03] rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>

            <div class="space-y-10 relative z-10">
                <div class="inline-block border border-white/20 bg-white/5 backdrop-blur-sm rounded-full px-5 py-2 text-xs font-bold text-emerald-100 tracking-widest uppercase">
                    Since 1948
                </div>
                <h2 class="text-4xl lg:text-5xl font-extrabold leading-[1.15] tracking-tight">
                    The right opportunity can turn dreams into limitless potential.
                </h2>
                <p class="text-emerald-50/70 text-lg leading-relaxed max-w-md font-medium">
                    Joining the college NCC unit builds character, comradeship, discipline, and a secular outlook, providing a rock-solid foundation for your future career.
                </p>
                
                <div class="grid grid-cols-2 gap-8 pt-8 border-t border-white/10">
                    <div>
                        <div class="text-5xl font-extrabold tracking-tight mb-2">30%</div>
                        <div class="text-sm text-emerald-100/80 font-medium">Of students report better academic focus.</div>
                    </div>
                    <div>
                        <div class="text-5xl font-extrabold tracking-tight mb-2">95%</div>
                        <div class="text-sm text-emerald-100/80 font-medium">Are placed in leadership roles post-graduation.</div>
                    </div>
                </div>
            </div>

            <div class="relative z-10 grid grid-cols-2 gap-6">
                <img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=500&auto=format&fit=crop" alt="Students studying" class="rounded-[2rem] h-48 md:h-72 w-full object-cover lg:mt-12 shadow-2xl ring-4 ring-white/10" />
                <img src="https://images.unsplash.com/photo-1529390079861-591de354faf5?q=80&w=500&auto=format&fit=crop" alt="Students graduating" class="rounded-[2rem] h-48 md:h-72 w-full object-cover shadow-2xl ring-4 ring-white/10" />
            </div>
        </div>
    </section>

    <section id="benefits" class="bg-white py-32 rounded-t-[4rem] border-t border-gray-100 shadow-[0_-20px_50px_-20px_rgba(0,0,0,0.02)] relative z-10">
        <div class="max-w-7xl mx-auto px-6 md:px-8">
            <div class="text-center mb-20">
                <div class="inline-block border border-gray-200 bg-gray-50 rounded-full px-5 py-2 text-xs font-bold text-gray-500 mb-6 tracking-wide uppercase shadow-sm">
                    ● Discover the Benefits
                </div>
                <h2 class="text-4xl lg:text-5xl font-extrabold max-w-3xl mx-auto text-gray-900 tracking-tight leading-tight">
                    Enhancing student life through diversity, inclusion, and strict discipline.
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="group bg-white border border-gray-100 p-10 rounded-[2.5rem] shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] hover:-translate-y-2 transition-all duration-500 text-center relative overflow-hidden">
                    <div class="w-20 h-20 mx-auto mb-8 bg-gray-50 rounded-full flex items-center justify-center text-4xl group-hover:bg-theme-green group-hover:text-white group-hover:scale-110 transition-all duration-500 shadow-sm">💡</div>
                    <h3 class="font-extrabold text-2xl mb-4 text-gray-900">Inspiring Student Life</h3>
                    <p class="text-gray-500 text-base mb-8 leading-relaxed font-medium">We focus on generating new knowledge & promoting extracurricular excellence within the campus.</p>
                </div>
                
                <div class="group bg-theme-green text-white border border-[#2c5243] p-10 rounded-[2.5rem] shadow-[0_20px_40px_-15px_rgba(44,82,67,0.3)] hover:shadow-[0_25px_50px_-15px_rgba(44,82,67,0.5)] hover:-translate-y-3 transition-all duration-500 text-center relative overflow-hidden md:-mt-6 md:mb-6">
                    <div class="w-20 h-20 mx-auto mb-8 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center text-4xl group-hover:scale-110 transition-transform duration-500 border border-white/20">🎓</div>
                    <h3 class="font-extrabold text-2xl mb-4">Career Advantages</h3>
                    <p class="text-emerald-50/80 text-base mb-8 leading-relaxed font-medium">Gain exclusive 'C' Certificate benefits for government jobs, armed forces, and higher education admissions.</p>
                </div>

                <div class="group bg-white border border-gray-100 p-10 rounded-[2.5rem] shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] hover:-translate-y-2 transition-all duration-500 text-center relative overflow-hidden">
                    <div class="w-20 h-20 mx-auto mb-8 bg-gray-50 rounded-full flex items-center justify-center text-4xl group-hover:bg-theme-green group-hover:text-white group-hover:scale-110 transition-all duration-500 shadow-sm">⚙️</div>
                    <h3 class="font-extrabold text-2xl mb-4 text-gray-900">Core Academics</h3>
                    <p class="text-gray-500 text-base mb-8 leading-relaxed font-medium">Our unit training schedules are masterfully designed to perfectly balance with your university classes.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="bg-gray-50 py-24 border-t border-gray-100 relative z-10">
        <div class="max-w-7xl mx-auto px-6 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <div class="space-y-8">
                    <div>
                        <div class="inline-block border border-gray-200 bg-white rounded-full px-5 py-2 text-xs font-bold text-gray-500 mb-6 tracking-wide uppercase shadow-sm">
                            ● Reach Out
                        </div>
                        <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight mb-4">
                            Let's get in touch.
                        </h2>
                        <p class="text-gray-600 text-lg leading-relaxed font-medium max-w-md">
                            Have questions about the enrollment process, camp schedules, or general inquiries? Our unit officers are here to help.
                        </p>
                    </div>

                    <div class="space-y-6 pt-4">
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 bg-white border border-gray-200 rounded-2xl flex items-center justify-center text-2xl shadow-sm shrink-0 text-theme-green">
                                📍
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg">Unit Office</h4>
                                <p class="text-gray-500 font-medium mt-1">Main College Campus,<br>Sangamner, Maharashtra, India</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 bg-white border border-gray-200 rounded-2xl flex items-center justify-center text-2xl shadow-sm shrink-0 text-theme-green">
                                ✉️
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg">Email Us</h4>
                                <p class="text-gray-500 font-medium mt-1">ncc.support@college.edu</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-10 md:p-12 rounded-[2.5rem] shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] border border-gray-100 relative">
                    <form action="#" method="POST" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">First Name</label>
                                <input type="text" placeholder="John" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Last Name</label>
                                <input type="text" placeholder="Doe" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                            <input type="email" placeholder="john@example.com" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Message</label>
                            <textarea rows="4" placeholder="How can we help you?" class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400 resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 rounded-2xl hover:bg-theme-green transition-colors shadow-lg mt-2">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-[#1a332a] text-emerald-50/80 pt-20 pb-10 border-t-4 border-theme-green relative z-10">
        <div class="max-w-7xl mx-auto px-6 md:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-theme-green rounded-xl flex items-center justify-center text-white font-extrabold text-xl shadow-md border border-white/10">
                            N
                        </div>
                        <span class="font-extrabold text-2xl tracking-tight text-white">College NCC</span>
                    </div>
                    <p class="font-medium leading-relaxed max-w-sm mb-6 text-emerald-100/70">
                        Dedicated to developing character, comradeship, discipline, and secular outlook in the youth to make them responsible citizens.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-bold text-white text-lg mb-6">Quick Links</h4>
                    <ul class="space-y-4 font-medium">
                        <li><a href="#" class="hover:text-white transition-colors">Home</a></li>
                        <li><a href="#why-join" class="hover:text-white transition-colors">Why to Join</a></li>
                        <li><a href="#benefits" class="hover:text-white transition-colors">Benefits</a></li>
                        <li><a href="#contact" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white text-lg mb-6">Management Portal</h4>
                    <ul class="space-y-4 font-medium">
                        <li><a href="#" @click.prevent="showAuthModal = true; isLogin = true" class="hover:text-white transition-colors">Cadet Login</a></li>
                        <li><a href="#" @click.prevent="showAuthModal = true; isLogin = false" class="hover:text-white transition-colors">New Enrollment</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Officer Dashboard</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-sm font-medium">
                <p>&copy; 2026 College NCC Unit. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <div x-show="showAuthModal" x-cloak class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="showAuthModal" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-gray-900/40 backdrop-blur-md transition-opacity" 
             @click="showAuthModal = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div x-show="showAuthModal" 
                 x-transition:enter="ease-out duration-400" 
                 x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 class="relative transform overflow-hidden rounded-[2.5rem] bg-white text-left shadow-[0_25px_50px_-12px_rgba(0,0,0,0.25)] ring-1 ring-black/5 transition-all sm:my-8 sm:w-full sm:max-w-lg">
                
                <button @click="showAuthModal = false" class="absolute top-6 right-6 text-gray-400 hover:text-gray-800 bg-gray-50 hover:bg-gray-200 rounded-full p-2.5 transition-colors focus:outline-none focus:ring-2 focus:ring-theme-green/50 z-10">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>

                <div class="px-8 md:px-10 pt-12 pb-10">
                    <div class="flex justify-center mb-10 bg-gray-100/80 p-1.5 rounded-full relative z-0">
                        <button @click="isLogin = true" :class="isLogin ? 'bg-white shadow-[0_2px_10px_-2px_rgba(0,0,0,0.1)] text-gray-900' : 'text-gray-500 hover:text-gray-800'" class="w-1/2 py-3 rounded-full font-bold text-sm transition-all duration-300 z-10">
                            Portal Login
                        </button>
                        <button @click="isLogin = false" :class="!isLogin ? 'bg-white shadow-[0_2px_10px_-2px_rgba(0,0,0,0.1)] text-gray-900' : 'text-gray-500 hover:text-gray-800'" class="w-1/2 py-3 rounded-full font-bold text-sm transition-all duration-300 z-10">
                            Cadet Enrollment
                        </button>
                    </div>

                    <div x-show="isLogin" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">Welcome Back</h3>
                            <p class="text-sm text-gray-500 mt-2 font-medium">Enter your secure credentials to access the portal.</p>
                        </div>
                        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                            @csrf

                            @if ($errors->has('email'))
                            <p class="text-red-500 text-xs mt-2 ml-1 font-semibold animate-fade-in-up">
                                {{ $errors->first('email') }}
                            </p>
                        @endif

                            <div>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" 
                                       class="w-full px-5 py-4 bg-gray-50/50 border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400 @error('email') border-red-500 @else border-gray-200 @enderror" required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-2 ml-1 font-semibold animate-fade-in-up">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <input type="password" name="password" placeholder="Password" 
                                       class="w-full px-5 py-4 bg-gray-50/50 border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400 @error('password') border-red-500 @else border-gray-200 @enderror" required>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-2 ml-1 font-semibold animate-fade-in-up">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center justify-between px-1 py-1">
                                <label class="flex items-center text-sm text-gray-600 font-medium cursor-pointer">
                                    <input type="checkbox" name="remember" class="mr-3 w-4 h-4 rounded border-gray-300 text-theme-green focus:ring-theme-green/50 cursor-pointer transition"> Remember me
                                </label>
                                <a href="#" class="text-sm font-bold text-theme-green hover:text-gray-900 transition-colors">Forgot password?</a>
                            </div>
                            
                            <button type="submit" class="w-full bg-gray-900 text-white font-bold py-4 rounded-2xl hover:bg-theme-green transition-colors shadow-lg mt-4">Sign In securely</button>
                        </form>
                    </div>

                    <div x-show="!isLogin" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
                        <div class="text-center mb-8">
                            <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight">Apply for NCC</h3>
                            <p class="text-sm text-gray-500 mt-2 font-medium">Begin your journey of unity and discipline today.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" id="cadet-register-form" class="space-y-4">
                            @csrf
                            <input type="hidden" name="name" id="full_name">

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="First Name"
                                        class="w-full px-5 py-4 bg-gray-50/50 border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400 @error('first_name') border-red-500 @else border-gray-200 @enderror" required>
                                    @error('first_name') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Last Name"
                                        class="w-full px-5 py-4 bg-gray-50/50 border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400 @error('last_name') border-red-500 @else border-gray-200 @enderror" required>
                                    @error('last_name') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address"
                                    class="w-full px-5 py-4 bg-gray-50/50 border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400 @error('email') border-red-500 @else border-gray-200 @enderror" required>
                                @error('email') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <input type="password" name="password" placeholder="Create Password"
                                    class="w-full px-5 py-4 bg-gray-50/50 border rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400 @error('password') border-red-500 @else border-gray-200 @enderror" required>
                                @error('password') <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                            </div>

                            <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                class="w-full px-5 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:bg-white focus:outline-none focus:border-theme-green focus:ring-4 focus:ring-theme-green/10 transition-all font-medium placeholder-gray-400" required>

                            <button type="submit" class="w-full bg-theme-green text-white font-bold py-4 rounded-2xl hover:bg-gray-900 transition-colors shadow-lg mt-2">
                                Submit Application
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Logic to concatenate names for Laravel compatibility
        document.getElementById('cadet-register-form')?.addEventListener('submit', function() {
            const first = document.getElementById('first_name').value;
            const last = document.getElementById('last_name').value;
            document.getElementById('full_name').value = first + ' ' + last;
        });
    </script>

</body>
</html>