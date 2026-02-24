<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NCC Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Custom green from the design */
        .theme-green { background-color: #2c5243; }
        .text-theme-green { color: #2c5243; }
    </style>
</head>
<body class="bg-[#f8f9fa] antialiased text-gray-800" x-data="{ showAuthModal: false, isLogin: true }">

    <nav class="flex justify-between items-center px-8 py-6 max-w-7xl mx-auto">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 theme-green rounded flex items-center justify-center text-white font-bold">N</div>
            <span class="font-bold text-xl tracking-tight">NCC<span class="text-theme-green">HQ</span></span>
        </div>
        
        <div class="hidden md:flex space-x-8 bg-white border border-gray-200 rounded-full px-8 py-3 text-sm font-semibold shadow-sm">
            <a href="#" class="text-gray-900">Home</a>
            <a href="#about" class="text-gray-500 hover:text-gray-900 transition">About Us</a>
            <a href="#camps" class="text-gray-500 hover:text-gray-900 transition">Camps</a>
            <a href="#contact" class="text-gray-500 hover:text-gray-900 transition">Contact Us</a>
        </div>

        <button @click="showAuthModal = true; isLogin = true" class="border-2 border-gray-200 bg-white rounded-full px-6 py-2.5 text-sm font-bold hover:bg-gray-50 transition shadow-sm">
            Login / Apply
        </button>
    </nav>

    <main class="max-w-7xl mx-auto px-8 pt-12 pb-24 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
            <div class="inline-block border border-gray-200 bg-white rounded-full px-4 py-1.5 text-xs font-semibold text-gray-600 shadow-sm">
                <span class="text-theme-green mr-2">●</span> Discipline. Leadership. Duty.
            </div>
            
            <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight text-gray-900">
                Forge Your Character into <span class="italic font-light text-gray-600">Action</span>
            </h1>
            
            <p class="text-gray-500 text-lg max-w-md leading-relaxed">
                Empowering youth with world-class training, leadership skills, and global opportunities to serve the nation.
            </p>
            
            <div class="flex items-center gap-4 pt-4">
                <button @click="showAuthModal = true; isLogin = false" class="theme-green text-white rounded-full px-8 py-4 font-bold hover:bg-emerald-900 transition shadow-lg">
                    Apply Now ↗
                </button>
                <button class="bg-white text-gray-800 rounded-full px-8 py-4 font-bold border border-gray-200 hover:bg-gray-50 transition">
                    Explore Camps
                </button>
            </div>
        </div>

        <div class="relative h-[500px] rounded-3xl overflow-hidden shadow-2xl">
            <img src="https://images.unsplash.com/photo-1544256718-3bcf237f3974?q=80&w=1000&auto=format&fit=crop" alt="NCC Training" class="w-full h-full object-cover" />
            
            <div class="absolute bottom-10 -left-6 w-48 h-32 bg-white p-2 rounded-xl shadow-xl hidden md:block border border-gray-100">
                <img src="https://images.unsplash.com/photo-1529390079861-591de354faf5?q=80&w=400&auto=format&fit=crop" alt="Cadets" class="w-full h-full object-cover rounded-lg" />
            </div>
        </div>
    </main>

    <section class="bg-white py-24">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center mb-16">
                <div class="inline-block border border-gray-200 rounded-full px-4 py-1.5 text-xs font-semibold text-gray-600 mb-4">
                    ● Why Choose NCC
                </div>
                <h2 class="text-3xl font-bold max-w-xl mx-auto">One of the largest, most disciplined youth organizations in the World</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="border border-gray-100 p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center group">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gray-50 rounded-full flex items-center justify-center text-3xl group-hover:bg-[#2c5243] group-hover:text-white transition">🎖️</div>
                    <h3 class="font-bold text-xl mb-3">Inspiring Leadership</h3>
                    <p class="text-gray-500 text-sm mb-6">We focus on generating new knowledge and promoting military discipline.</p>
                    <a href="#" class="text-theme-green font-semibold text-sm hover:underline">Read More ↗</a>
                </div>
                
                <div class="theme-green text-white p-8 rounded-2xl shadow-lg text-center transform scale-105">
                    <div class="w-16 h-16 mx-auto mb-6 bg-white/20 rounded-full flex items-center justify-center text-3xl">🏕️</div>
                    <h3 class="font-bold text-xl mb-3">Camp Training</h3>
                    <p class="text-emerald-100 text-sm mb-6">Real-world survival, drills, and physical conditioning across the country.</p>
                    <a href="#" class="text-white font-semibold text-sm hover:underline">Read More ↗</a>
                </div>

                <div class="border border-gray-100 p-8 rounded-2xl shadow-sm hover:shadow-md transition text-center group">
                    <div class="w-16 h-16 mx-auto mb-6 bg-gray-50 rounded-full flex items-center justify-center text-3xl group-hover:bg-[#2c5243] group-hover:text-white transition">🤝</div>
                    <h3 class="font-bold text-xl mb-3">Community Service</h3>
                    <p class="text-gray-500 text-sm mb-6">Actively participating in social development and national relief efforts.</p>
                    <a href="#" class="text-theme-green font-semibold text-sm hover:underline">Read More ↗</a>
                </div>
            </div>
        </div>
    </section>

    <div x-show="showAuthModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-show="showAuthModal" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="showAuthModal = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
            <div x-show="showAuthModal" x-transition class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                
                <button @click="showAuthModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>

                <div class="p-8">
                    <div class="flex justify-center mb-8 bg-gray-100 rounded-full p-1">
                        <button @click="isLogin = true" :class="isLogin ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="w-1/2 py-2 rounded-full font-semibold text-sm transition-all">
                            Sign In
                        </button>
                        <button @click="isLogin = false" :class="!isLogin ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="w-1/2 py-2 rounded-full font-semibold text-sm transition-all">
                            Register
                        </button>
                    </div>

                    <div x-show="isLogin">
                        <h3 class="text-2xl font-bold mb-6 text-center">Welcome Back</h3>
                        <form method="POST" action="{{ route('login') ?? '#' }}" class="space-y-4">
                            @csrf
                            <input type="email" name="email" placeholder="Email Address" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2c5243] focus:ring-1 focus:ring-[#2c5243]" required>
                            <input type="password" name="password" placeholder="Password" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2c5243] focus:ring-1 focus:ring-[#2c5243]" required>
                            <button type="submit" class="w-full theme-green text-white font-bold p-4 rounded-xl hover:bg-emerald-900 transition">Login</button>
                        </form>
                    </div>

                    <div x-show="!isLogin">
                        <h3 class="text-2xl font-bold mb-6 text-center">Cadet Registration</h3>
                        <form method="POST" action="{{ route('register') ?? '#' }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="name" placeholder="First Name" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2c5243]" required>
                                <input type="text" name="last_name" placeholder="Last Name" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2c5243]" required>
                            </div>
                            <input type="text" name="regimental_number" placeholder="Regimental Number" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2c5243]" required>
                            <input type="email" name="email" placeholder="Email Address" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2c5243]" required>
                            <input type="password" name="password" placeholder="Create Password" class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#2c5243]" required>
                            <button type="submit" class="w-full bg-gray-900 text-white font-bold p-4 rounded-xl hover:bg-black transition">Create Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>