@extends('hpreport.index')

@section('hprcontent')


    <div class="container">

        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12"><h4><span class="fw-bold">{{ $article->name }}</span></h4></div>
                        </div>

                        <div class="row">
                            <table class="table table-sm table-light">
                                <thead>
                                <tr>
                                    <th scope="col" class="fw-normal">Altum id</th>
                                    <th scope="col" class="fw-normal">Kod</th>
                                    {{--<th scope="col" class="fw-normal">Nazwa</th>--}}
                                    <th scope="col" class="fw-normal">Nr katalogowy</th>
                                    <th scope="col" class="fw-normal">Ilość</th>
                                    <th scope="col" class="fw-normal">Rezerwacje</th>
                                    <th scope="col" class="fw-normal">Zamówienia</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="fw-bold">{{ $article->article_id }}</td>
                                    <td class="fw-bold">{{ $article->code }}</td>
                                    {{--<td class="fw-bold">{{ $article->name }}</td>--}}
                                    <td class="fw-bold">{{ $article->catalogue_number }}</td>
                                    <td class="fw-bold">{{ $article->quantity }}</td>
                                    <td class="fw-bold">{{ $article->reservations }}</td>
                                    <td class="fw-bold">{{ $article->orders }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="card-body">

                        <div class="row">
                            <table class="table table-sm table-light">
                                <thead>
                                <tr>
                                    <th scope="col">Magazyn</th>
                                    {{--
                                    <th scope="col">Data</th>
                                    <th scope="col">Dokument pierwotny</th>
                                                        --}}
                                    <th scope="col">Data</th>
                                    <th scope="col">Dokument</th>
                                    <th scope="col">Ilość</th>
                                    <th scope="col">Rezerwacje</th>
                                    <th scope="col">Zamówienia</th>
                                    <th scope="col">Cena</th>
                                    {{--<th scope="col">Wartość</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($stocks as $stock)

                                    <tr @if($stock->is_blocked == true) class="text-danger" @endif>
                                        <td>{{ $stock->mag_name . " - " . $stock->mag_symbol }}</td>
                                        {{--
                                        <td>{{ $stock->primary_doc_date }}</td>
                                        <td>{{ $stock->primary_doc }}</td>
                                        --}}
                                        <td>{{ $stock->input_doc_date }}</td>
                                        <td>{{ $stock->input_doc }}</td>
                                        <td>{{ $stock->quantity }}</td>
                                        <td>{{ $stock->reservations }}</td>
                                        <td>{{ $stock->orders }}</td>
                                        <td>{{ $stock->unit_price }}</td>
                                        {{--<td>{{ $stock->purchase_value }}</td>--}}
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

