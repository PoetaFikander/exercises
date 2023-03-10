@extends('hpreport.index')

@section('hprcontent')
    <div class="container">

        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                <h4>Wydania</h4>
                            </div>
                            <div class="col-md-8"></div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <form class="d-flex flex-row align-items-center flex-wrap">
                                <label class="my-1 me-2" for="for_year">Rok</label>
                                <select class="form-select my-1 me-sm-2 w-auto" id="for_year" data-toggle="h_a_s_for_year">
                                    @foreach($ad->years as $year)
                                        <option
                                            value="{{ $year }}"
                                            @if($ad->weekData->year == $year) selected @endif
                                        >
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>

                                <label class="my-1 me-2" for="for_week">Tydzień</label>
                                <select class="form-select my-1 me-sm-2 w-auto" id="for_week" data-toggle="h_a_s_for_week">
                                    @foreach($ad->weeks as $week)
                                        <option
                                            data-from="{{ $week->w_start }}"
                                            value="{{ $week->w_no }}"
                                            @if($week->w_no == $ad->weekData->w_no) selected @endif
                                        >
                                            {{ $week->w_no.' - '.$week->w_start . ':' . $week->w_end }}
                                        </option>
                                    @endforeach
                                </select>

                            </form>

                        </div>

                        <div class="row mt-2">
                            <div class="table-responsive">

                                <table class="table table-striped table-sm table-hover my-table">
                                    <thead>
                                    <tr class="text-start">
                                        <th scope="col" class="text-nowrap">Altum id</th>
                                        <th scope="col">Kod</th>
                                        <th scope="col">Nazwa</th>
                                        <th scope="col" class="text-nowrap">Nr katalogowy</th>
                                        <th scope="col">Ilość</th>
                                        <th scope="col">Dokument</th>
                                        <th scope="col">Nabywca</th>
                                        <th scope="col">Stan dokumentu</th>
                                        {{--<th scope="col">Kontrakt</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ad->articles as $article)
                                        {{--<tr @if($article->contract_customer_id == 0) class="_text-danger" @endif>--}}
                                        <tr class="@if($article->document_state == 'Niezatwierdzony') text-success @endif">
                                            <td>{{ $article->article_id }}</td>
                                            <td>{{ $article->code }}</td>
                                            <td class="ellipis">{{ $article->name }}</td>
                                            <td>{{ $article->catalogue_number }}</td>
                                            <td class="text-end">{{ $article->quantity }}</td>
                                            <td>{{ $article->document_no }}</td>
                                            <td class="@if($article->contract_customer_id == 0) text-decoration-underline @endif">{{ $article->customer_name }}</td>
                                            <td>{{ $article->document_state }}</td>
                                            {{--<td>{{ $article->contract_customer_id }}</td>--}}
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


    </div>
@endsection

