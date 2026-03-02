<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'NCC Portal' }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-2xl p-8">
        @yield('content')
    </div>

</body>
</html>