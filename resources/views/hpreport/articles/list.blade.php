@extends('hpreport.index')

@section('hprcontent')

    <div class="container">

        <div class="table-responsive">

            <table class="table table-striped table-sm table-hover my-table">
                <thead>
                <tr>
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
                        data-id="{{ $article->article_id }}"
                    >
                        <th scope="row">{{ $article->id }}</th>
                        <td>{{ $article->article_id }}</td>
                        <td>{{ $article->code }}</td>
                        <td>{{ $article->name }}</td>
                        <td>{{ $article->catalogue_number }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection

