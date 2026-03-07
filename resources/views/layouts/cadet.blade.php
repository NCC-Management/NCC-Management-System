<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NCC Cadet Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body{
            margin:0;
            font-family:Arial;
            background:#f5f7fa;
        }

        .navbar{
            background:#1b4332;
            color:white;
            padding:15px 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .menu a{
            color:white;
            text-decoration:none;
            margin-right:20px;
            font-size:14px;
        }

        .menu a:hover{
            text-decoration:underline;
        }

        .container{
            padding:40px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:8px;
            box-shadow:0 3px 10px rgba(0,0,0,0.1);
        }

        button{
            background:#e63946;
            border:none;
            padding:8px 16px;
            color:white;
            border-radius:5px;
            cursor:pointer;
        }

        button:hover{
            background:#c1121f;
        }
    </style>
</head>

<body>

<div class="navbar">

    <div>
        <strong>NCC Cadet Portal</strong>
    </div>

    <div class="menu">

        <a href="{{ route('cadet.dashboard') }}">Dashboard</a>
        <a href="#">Attendance</a>
        <a href="#">Events</a>
        <a href="#">Forms</a>

    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button>Logout</button>
    </form>

</div>

<div class="container">
    @yield('content')
</div>

</body>
</html>