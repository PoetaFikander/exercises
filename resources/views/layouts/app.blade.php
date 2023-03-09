<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <!-- My Scripts -->
    {{--
        <script src="{{ asset('js/main.js') }}" defer></script>
    --}}

</head>
<body>
<div id="app">

    <div id="overlay-spinner">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <nav class="navbar navbar-expand-md navbar-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                    {{--@can('isAdmin','isHPReports')
                    @can('isHPReports')
                        <a class="nav-link" href="{{ route('hpreport.index') }}">Raport HP</a>
                    @endcan
                    --}}

                    @canany(['isAdmin', 'isHPReports'])
                        <a class="nav-link" href="{{ route('hpreport.index') }}">Raport HP</a>
                    <!-- The current user can update, view, or delete the post... -->
                    {{--@elsecanany(['create'], \App\Models\Post::class)--}}
                    <!-- The current user can create a post... -->
                    @endcanany

                    @canany(['isAdmin', 'isProfits'])
                        <a class="nav-link" href="{{ route('profits.index') }}">Profitowość</a>
                    @endcanany

                    @can('isAdmin')
                        <a class="nav-link" href="{{ route('users.list') }}">Użytkownicy</a>
                    @endcan
                    {{--<a class="nav-link" href="{{ route('users.list') }}">{{ __('Użytkownicy') }}</a>--}}
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-0">
        @yield('content')
    </main>
</div>

<script src="{{ asset('DataTables/datatables.min.js') }}" defer></script>
<script src="{{ asset('Datepicker/bootstrap-datepicker.min.js') }}" defer></script>
<script src="{{ asset('js/main.js') }}" defer></script>

<script type="module">
    @yield('js')
</script>
@yield('js-files')

</body>
</html>
