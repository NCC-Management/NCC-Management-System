<!DOCTYPE html>
<html>
<head>
    <title>NCC Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { overflow-x: hidden; }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #1e293b;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }
        .sidebar a:hover {
            background: #334155;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="p-3">NCC Admin</h4>

    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('cadets.index') }}">Cadets</a>
    <a href="{{ route('units.index') }}">Units</a>
    <a href="{{ route('events.index') }}">Events</a>
    <a href="{{ route('attendance.index') }}">Attendance</a>

    <hr>
    <form method="POST" action="{{ route('logout') }}" class="p-3">
        @csrf
        <button class="btn btn-danger w-100">Logout</button>
    </form>
</div>

<div class="content">
    @yield('content')
</div>

</body>
</html>