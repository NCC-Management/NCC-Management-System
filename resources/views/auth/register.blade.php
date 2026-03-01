<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded shadow-md w-96">
    <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

   <form method="POST" action="{{ route('register.custom') }}">
        @csrf

        <div class="mb-4">
            <label>Full Name</label>
            <input type="text" name="name" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full border p-2 rounded">
        </div>

        <button class="w-full bg-blue-600 text-white p-2 rounded">
            Register
        </button>
    </form>

    <p class="mt-4 text-center">
        Already have account?
        <a href="{{ route('login') }}" class="text-green-600">Login</a>
    </p>
</div>

</body>
</html>