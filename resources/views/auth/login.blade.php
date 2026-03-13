<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded shadow-md w-96">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" required class="w-full border p-2 rounded">
        </div>

        <button class="w-full bg-green-600 text-white p-2 rounded">
            Login
        </button>
    </form>

    <p class="mt-4 text-center">
        Don't have account?
        <a href="{{ route('register') }}" class="text-blue-600">Register</a>
    </p>
</div>

</body>
</html>