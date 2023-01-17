@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <table class="table table-hover table-bordered table-sm">

                    <thead class="table-info">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Imię</th>
                        <th scope="col">Nazwisko</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Akcje</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{--  --}}
                                <button
                                    class="btn btn-danger btn-sm"
                                    data-toggle="delete"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name . " " . $user->surname }}"
                                >
                                    <i class="bi-trash">Usuń</i>
                                </button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>

@endsection

@section('jscript')
@endsection



