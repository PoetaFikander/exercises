@extends('layouts.app')

@section('content')

    <div class="container">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('hpreport.index') }}">Raport HP</a>

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('hpreport.articles.list') }}">Artykuły</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('hpreport.customers.list') }}">Kontrahenci</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('hpreport.articles.delivery') }}">Dostawy</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('hpreport.articles.sale') }}">Wydania</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('hpreport.reports.create') }}">Nowy raport</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('hpreport.reports.list') }}">Raporty</a>
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
    {{--
        <script src="{{ asset('js/hpreport.js') }}" defer></script>
    --}}

@endsection


