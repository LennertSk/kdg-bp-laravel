<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Squery | Simple Survey Builder</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="css/app.css"> -->

</head>
<body>
    <div id='app'>
        <!-- Navigation Top Bar  -->
        @if(Request::is('dashboard'))
        <nav class='navigation dashboard'>
        @else 
        <nav class='navigation'>
        @endif
            <ul class='navbar'>
                <li class='navbar__logo'>
                    <a class='logo' href='{{ url("/") }}'>
                        <img src='{{ URL::to("/images/logo.png") }}' alt='Squery Logo'>
                    </a>
                </li>
                @if(Request::is('/'))
                <li class='navbar__cta'>
                    <a href='{{ url("/dashboard") }}' class='btn-dash'>Already made one?</a>
                    <a href='{{ url("/get-started") }}' class='btn'>Make your own!</a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- Page Content -->
        <main class='content'>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class='footer'>
            <ul class='wrapper'>
                <li><a href='{{ url("/terms") }}' class='btn-dash'>Privacy</a></li>
                <li><a href='{{ url("/terms") }}' class='btn-dash'>Terms of use</a></li>
            </ul>
        </footer>

    </div>
</body>
</html>
