@extends('layouts.app')

@section('content')

    <div class="container">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Raport HP</a>

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('hpreport.articles') }}">Artykuły</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="#">Zasoby</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <div class="py-0">
            @yield('hprcontent')
        </div>

    </div>

@endsection

@section('js')
@endsection

@section('js-files')
    {{-- <script src="{{ asset('js/users.js') }}" defer></script> --}}
@endsection


