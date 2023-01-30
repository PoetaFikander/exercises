@extends('hpreport.index')

@section('hprcontent')
    <div class="container">

        <div class="row">


            <form class="d-flex flex-row align-items-center flex-wrap" method="POST" action="{{ route('hpreport.report') }}">
                @csrf
                <label class="my-1 me-2" for="for_year">Rok</label>
                <select class="form-select my-1 me-sm-2 w-auto" id="for_year" data-toggle="h_r_for_year">
                    @foreach($ad->years as $year)
                        <option
                            value="{{ $year }}"
                            @if($ad->weekDays->year == $year) selected @endif
                        >
                            {{ $year }}
                        </option>
                    @endforeach
                </select>

                <label class="my-1 me-2" for="for_week">Tydzień</label>
                <select class="form-select my-1 me-sm-2 w-auto" id="for_week" data-toggle="h_r_for_week">
                    @foreach($ad->weeks as $week)
                        <option
                            data-from="{{ $week->w_start }}"
                            value="{{ $week->w_no }}"
                            @if($week->w_no == $ad->weekDays->w_no) selected @endif
                        >
                            {{ $week->w_start . ' - ' . $week->w_end }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Generuj raport</button>
            </form>

        </div>

        <div class="table-responsive">

            <table class="table table-sm table-light">
                <thead>
                <tr class="text-start">
                    @foreach($headers as $key=>$value)
                        <th scope="col" class="text-nowrap">{{ $key }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>

                @foreach($data as $row)
                    <tr>
                        @foreach($row as $key=>$value)
                            <td class="text-nowrap">{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>


        {{--
        <div class="row">

            <table class="table table-sm table-light">
                <thead>
                <tr class="text-start">
                    <th scope="col">Start period</th>
                    <th scope="col">End period</th>
                    <th scope="col">HP Product Number</th>
                    <th scope="col">Total Sellin Units</th>
                    <th scope="col">Inventory Units</th>
                    <th scope="col">Sales Units</th>
                    <th scope="col">Transaction Date</th>
                    <th scope="col">Invoice</th>
                    <th scope="col">Customer</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ad->sale as $article)
                    <tr>
                        <td>{{ $ad->weekDays->w_start }}</td>
                        <td>{{ $ad->weekDays->w_end }}</td>
                        <td>{{ $article->catalogue_number }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ $article->quantity }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ $article->customer_name }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        --}}


        {{--
        <div class="row">

            <table class="table table-sm table-light">
                <thead>
                <tr class="text-center">
                    <th scope="col">Altum id</th>
                    <th scope="col">Kod</th>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Nr katalogowy</th>
                    <th scope="col">Ilość</th>

                    <th scope="col">Nabywca</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ad->sale as $article)
                    <tr>
                        <td>{{ $article->article_id }}</td>
                        <td>{{ $article->code }}</td>
                        <td class="ellipis">{{ $article->name }}</td>
                        <td>{{ $article->catalogue_number }}</td>
                        <td class="text-end">{{ $article->quantity }}</td>
                        <td>{{ $article->customer_name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    --}}

    </div>




@endsection

