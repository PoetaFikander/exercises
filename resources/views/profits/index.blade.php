@extends('layouts.app')

@section('content')

    <div class="container">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('profits.index') }}">Profitowość</a>

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('profits.devices.list') }}">Urządzenia</a>
                        </li>

                        @can('isAdmin')
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('profits.contracts.list') }}">Umowy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('profits.customers.list') }}">Kontrahenci</a>
                            </li>
                        @endcan

                    </ul>
                </div>
            </div>
        </nav>

        <div class="py-0">
            @yield('profitcontent')
        </div>

    </div>

@endsection

@section('js')
@endsection

@section('js-files')
    {{--
        <script src="{{ asset('js/hpreport.js') }}" defer></script>
    --}}

@endsection


