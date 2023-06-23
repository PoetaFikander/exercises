@extends('layouts.app')

@section('content')

    <div class="container">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('bok.index') }}">BOK</a>

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('bok.contracts.index') }}">Umowy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('bok.devices.index') }}">Urządzenia</a>
                        </li>
                        {{--
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('bok.technician.index') }}">Technicy</a>
                        </li>
                        --}}
                        @can('isAdmin')
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('bok.review.index') }}">Przeglądy</a>
                        </li>
                        @endcan

                    </ul>
                </div>
            </div>
        </nav>

        <div class="py-0">
            @yield('bokcontent')
        </div>

    </div>

@endsection

@section('js')
    <script src="{{ asset('js/bok/bok.js') }}" type="module"></script>
@endsection
