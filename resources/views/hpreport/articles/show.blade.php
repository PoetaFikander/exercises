@extends('hpreport.index')

@section('hprcontent')


    <div class="container">

        <div class="row">
            <table class="table table-sm table-light">
                <thead>
                <tr>
                    <th scope="col" class="fw-normal">Altum id</th>
                    <th scope="col" class="fw-normal">Kod</th>
                    <th scope="col" class="fw-normal">Nazwa</th>
                    <th scope="col" class="fw-normal">Nr katalogowy</th>
                    <th scope="col" class="fw-normal">Ilość</th>
                    <th scope="col" class="fw-normal">Rezerwacje</th>
                    <th scope="col" class="fw-normal">Zamówienia</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="fw-bold">{{ $article->altum_id }}</td>
                    <td class="fw-bold">{{ $article->code }}</td>
                    <td class="fw-bold">{{ $article->name }}</td>
                    <td class="fw-bold">{{ $article->catalogue_number }}</td>
                    <td class="fw-bold">{{ $article->quantity }}</td>
                    <td class="fw-bold">{{ $article->reservations }}</td>
                    <td class="fw-bold">{{ $article->orders }}</td>
                </tr>
                </tbody>
            </table>
        </div>

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


@endsection

