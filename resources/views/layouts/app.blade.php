<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskMan</title>

    <!-- Bootstrap CSS (compiled by npm) -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @livewireStyles
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">TaskMan</a>
        <div class="collapse navbar-collapse">
            <!-- Right side -->
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                @else
                    <li class="nav-item"><span class="nav-link">Hi, {{ auth()->user()->name }}</span></li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        @auth
        <div class="col-md-2 bg-light vh-100">
            <div class="p-3">
                <h5>Menu</h5>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">My Tasks</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-10 py-4">
            @yield('content')
        </div>
        @endauth

        @guest
        <div class="col-md-12 py-4">
            @yield('content')
        </div>
        @endguest
    </div>
</div>

@livewireScripts
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
