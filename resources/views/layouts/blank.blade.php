<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style>
            header{
                top: 10px;
                right: 10px;
                width: 100%;
                padding: 10px 20px;
                text-align: right;
            }
        </style>
    </head>
    <body>
        <header>
            <a class="mr-3" href="{{ route('audition') }}">Audition</a>
            <a class="mr-3" href="{{ route('about') }}">About</a>
            <a class="mr-3" href="{{ route('playing') }}">Playing</a>
            @if(!Auth::check())
                <a class="mr-3" href="{{ route('login') }}">Login</a>
                <a class="mr-3" href="{{ route('userType') }}">Register</a>
            @else
                <a class="mr-3" href="{{ route('dashboard') }}">{{ Auth::user()->name }}</a>
                <form class="d-inline-block" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="mr-3" href="#" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                </form>
            @endif
        </header>
        <div class="font-sans text-gray-900 antialiased">
            @yield('content')
        </div>
    </body>
</html>
