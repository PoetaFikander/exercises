@extends('hpreport.index')

@section('hprcontent')

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Kod</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Nr katalogowy</th>
        </tr>
        </thead>
        <tbody>
        @foreach($articles as $article)
            <tr>
                <th scope="row">{{ $article->id }}</th>
                <td>{{ $article->code }}</td>
                <td>{{ $article->name }}</td>
                <td>{{ $article->catalogue_number }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
