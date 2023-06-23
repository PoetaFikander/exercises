@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h3>Lista użytkowników</h3>
            </div>
            <div class="col-6">
                <a class="float-end" href="{{ route('users.create') }}">
                    <button type="button" class="btn btn-primary btn-sm">Dodaj</button>
                </a>
            </div>
        </div>
        <div class="row justify-content-center">


            <table class="table table-hover table-bordered table-sm">

                <thead class="table-borderless">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Imię</th>
                    <th scope="col">Nazwisko</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Telefon</th>
                    <th scope="col">Typ</th>
                    <th scope="col">Role</th>
                    <th scope="col">Oddział</th>
                    <th scope="col">Aktywny</th>
                    <th scope="col" class="">Akcje</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->type->name }}</td>
                        <td>{{ implode(', ',$userRoles[$user->id]) }} </td>
                        <td>{{ $user->department->name }}</td>
                        <td>{{ $user->is_active ? 'Tak' : 'Nie' }}</td>
                        <td>
                            {{--  --}}
                            <a href="{{ route('users.show', $user->id) }}">
                                <button class="btn btn-primary btn-sm">
                                    <i class="bi-search"></i>
                                </button>
                            </a>

                            <a href="{{ route('users.edit', $user->id) }}">
                                <button class="btn btn-success btn-sm">
                                    <i class="bi-pencil"></i>
                                </button>
                            </a>

                            <button
                                class="btn btn-danger btn-sm"
                                data-toggle="delete"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name . " " . $user->surname }}"
                            >
                                <i class="bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>


        </div>
    </div>

@endsection

@section('js')
@endsection

@section('js-files')
    {{--
    <script src="{{ asset('js/users.js') }}" defer></script>
    --}}
@endsection


