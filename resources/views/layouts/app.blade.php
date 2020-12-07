<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Fitness') }}</title> -->
    <title>Fitness</title>


    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="//momentjs.com/downloads/moment.min.js" def=""></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js" def=""></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.print.css" media="print" />
    @yield('scripts')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light card-header shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @if (Auth::check())
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link @yield('home') text-white" href="{{url('/home')}}">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <!-- <a class="nav-link dropdown-toggle @yield('workouts')" href="/workouts">Workouts</a> -->
                            <a class="nav-link dropdown-toggle @yield('workouts') text-white" href="{{url('/workouts')}}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Workouts
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{url('/activity')}}">Activity</a>
                                <a class="dropdown-item" href="{{url('/alcohol')}}">Alcohol</a>
                                <a class="dropdown-item" href="{{url('/snack')}}">Snack</a>
                                <a class="dropdown-item" href="{{url('/sleep')}}">Sleep</a>
                                <a class="dropdown-item" href="{{url('/mood')}}">Mood</a>
                                <a class="dropdown-item" href="{{url('/weight')}}">Weight</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @yield('calendar') text-white" href="{{url('/calendar')}}">Calendar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @yield('statistics') text-white" href="{{url('/statistics')}}">Statistics</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                    @else
                    <div class="text-white" style="width: 50%; margin: 0 auto;">
                        <h4 class="text-center">Fitness & Wellbeing</h4>
                    </div>

                    @endif

                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
@yield('chartScript')
@yield('jsScript')
</html>