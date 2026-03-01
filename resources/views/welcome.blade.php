<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCC Management System - The Sangamner College</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.8s ease-out; }
    </style>
</head>

<body class="font-sans text-gray-800">

<!-- ================= HEADER ================= -->
<header class="fixed top-0 left-0 right-0 z-50 bg-gray-900 shadow-lg">
    <nav class="container mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-700 rounded-full flex items-center justify-center text-white font-bold text-xl">
                NCC
            </div>
            <span class="ml-2 text-white font-semibold hidden sm:block">
                Management System
            </span>
        </div>

        <div class="space-x-4">
            @auth
                <a href="/dashboard"
                   class="bg-green-600 px-4 py-2 rounded text-white">
                    Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="bg-red-600 px-4 py-2 rounded text-white">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="bg-green-700 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="bg-blue-700 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Register
                </a>
            @endauth
        </div>
    </nav>
</header>

<!-- ================= HERO SECTION ================= -->
<section class="relative h-screen flex items-center justify-center text-center">

    <div class="absolute inset-0">
        <img src="https://picsum.photos/seed/sangamner-college/1920/1080.jpg"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    </div>

    <div class="relative z-10 text-white fade-in">
        <h1 class="text-5xl font-bold mb-4">
            NCC MANAGEMENT SYSTEM
        </h1>

        <p class="text-2xl text-green-400 mb-6">
            Unity and Discipline – National Cadet Corps
        </p>

        <p class="max-w-3xl mx-auto mb-8">
            The National Cadet Corps is the Indian military cadet corps
            with its Headquarters at New Delhi.
            It is open to school and college students on voluntary basis.
        </p>

        @guest
        <div class="flex gap-4 justify-center">
            <a href="{{ route('login') }}"
               class="bg-green-700 px-6 py-3 rounded-lg hover:bg-green-600">
                Login
            </a>

            <a href="{{ route('register') }}"
               class="bg-blue-800 px-6 py-3 rounded-lg hover:bg-blue-700">
                Register
            </a>
        </div>
        @endguest
    </div>

</section>

<!-- ================= ABOUT SECTION ================= -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="bg-white rounded-xl shadow-xl p-10 text-center">
            <h2 class="text-3xl font-bold mb-6 text-green-700">
                The Sangamner College, Sangamner
            </h2>

            <p class="text-gray-700 text-lg">
                Established in 1971 | NAAC Accredited 'A+' Grade
            </p>

            <div class="mt-6 text-gray-600">
                The Sangamner College is a premier institution dedicated
                to excellence in higher education and overall development
                of students.
            </div>
        </div>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-gray-900 text-white py-10">
    <div class="container mx-auto text-center">
        <p>© {{ date('Y') }} The Sangamner College NCC Management System</p>
    </div>
</footer>

</body>
</html>