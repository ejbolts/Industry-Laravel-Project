<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app2.css') }}" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>

     <!--- user is not logged in --->
    @if (Auth::guest())
    <nav class="nav-bar">
        <a class="btn" style="margin: 0px" href="{{ route('login') }}">Login</a>
        <a class="btn" style="margin: 0px"href="{{ route('register') }}">Register</a>
    </nav>

    @else  <!--- user is logged in --->
    <nav class="nav-bar">
        <h3 style="margin: 0px">
            @if(Auth::user()->student)
                <a href="{{ route('student.profile', Auth::user()->student->id) }}">
                    {{ Auth::user()->name }} 
                </a>
                - Student
            @elseif(Auth::user()->teacher)
                {{ Auth::user()->name }} - Teacher
            @elseif(Auth::user()->industry_partner)
                {{ Auth::user()->name }} - Industry Partner
        
            @endif
        </h3>
        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <input class="btn-delete" style="margin:0px" type="submit" value="Logout">
        </form>
    </nav>

    @endif
    @yield('content')
</body>
</html>