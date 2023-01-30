@extends('hpreport.index')

@section('hprcontent')

    <table class="table table-striped table-hover">
        <thead>
        <tr class="table-dark">
            <th scope="col">Id</th>
            <th scope="col" class="text-nowrap">Altum id</th>
            <th scope="col">Kod</th>
            <th scope="col">Nazwa</th>
            <th scope="col" class="text-nowrap">Nr katalogowy</th>
        </tr>
        </thead>
        <tbody>
        @foreach($articles as $article)
                <tr
                    data-toggle="articlesshow"
                    data-id="{{ $article->altum_id }}"
                >
                    <th scope="row">{{ $article->id }}</th>
                    <td>{{ $article->altum_id }}</td>
                    <td>{{ $article->code }}</td>
                    <td>{{ $article->name }}</td>
                    <td>{{ $article->catalogue_number }}</td>
                </tr>
        @endforeach
        </tbody>
    </table>

@endsection

