@extends('hpreport.index')

@section('hprcontent')
    <div class="container">


        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                <h4>Generator raportów</h4>
                            </div>
                            <div class="col-md-8"></div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <form class="d-flex flex-row align-items-center flex-wrap" method="POST" action="{{ route('hpreport.reports.create') }}">
                                @csrf
                                <label class="my-1 me-2" for="for_year">Rok</label>
                                <select class="form-select my-1 me-sm-2 w-auto" id="for_year" name="for_year" data-toggle="h_r_c_for_year">
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
                                <select class="form-select my-1 me-sm-2 w-auto" id="for_week" name="for_week" data-toggle="h_r_c_for_week">
                                    @foreach($ad->weeks as $week)
                                        <option
                                            value="{{ $week->w_start }}"
                                            @if($week->w_no == $ad->weekData->w_no) selected @endif
                                        >
                                            {{ $week->w_no.' - '.$week->w_start . ':' . $week->w_end }}
                                        </option>
                                    @endforeach
                                </select>

                                <label class="my-1 me-2" for="for_reportid">Raport źródłowy</label>
                                <select class="form-select my-1 me-sm-2 w-auto" id="for_reportno" name="for_reportid" data-toggle="h_r_c_for_reportid">

                                    @if(count($ad->previousReports) > 0)
                                        @foreach($ad->previousReports as $report)
                                            <option value="{{ $report->report_id }}"
                                                    @if($ad->pReSelected->report_id == $report->report_id) selected @endif >
                                                {{ $report->report_no }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="-1">-- brak --</option>
                                    @endif

                                </select>

                                <button type="submit" class="btn btn-primary">Generuj raport</button>
                            </form>

                        </div>

                        @if(count($ad->report) > 0)
                            <div class="row table-reports">

                                <div class="col-md-12 py-2">

                                    <div class="card">

                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <h4>Raport {{ $ad->reportNo }}</h4>
                                                </div>
                                                <div class="col-md-8"></div>
                                                <div class="col-md-2"></div>
                                            </div>
                                        </div>

                                        <div class="card-body">

                                            <div class="table-responsive">

                                                <table class="table table-sm table-hover my-table">
                                                    <thead>
                                                    <tr class="text-start">
                                                        <th scope="col" class="text-nowrap">Country</th>
                                                        <th scope="col" class="text-nowrap">Partner ID</th>
                                                        <th scope="col" class="text-nowrap">Partner Name</th>
                                                        <th scope="col" class="text-nowrap">Start period</th>
                                                        <th scope="col" class="text-nowrap">End period</th>
                                                        <th scope="col" class="text-nowrap">HP Product Number</th>
                                                        <th scope="col" class="text-nowrap">Total Sellin Units</th>
                                                        <th scope="col" class="text-nowrap">Inventory Units</th>
                                                        <th scope="col" class="text-nowrap">Sales Units</th>
                                                        <th scope="col" class="text-nowrap">Transaction Date</th>
                                                        <th scope="col" class="text-nowrap">Channel Partner to Customer Invoice ID</th>

                                                        <th scope="col" class="text-nowrap">Sold-to Customer ID</th>
                                                        <th scope="col" class="text-nowrap">Sold To Customer Name</th>
                                                        <th scope="col" class="text-nowrap">Sold To Company Tax ID</th>
                                                        <th scope="col" class="text-nowrap">Sold To Address Line 1</th>
                                                        <th scope="col" class="text-nowrap">Sold To Address Line 2</th>
                                                        <th scope="col" class="text-nowrap">Sold To City</th>
                                                        <th scope="col" class="text-nowrap">Sold To Postal Code</th>
                                                        <th scope="col" class="text-nowrap">Sold To Country Code</th>

                                                        <th scope="col" class="text-nowrap">Ship-to Customer ID</th>
                                                        <th scope="col" class="text-nowrap">Ship To Customer Name</th>
                                                        <th scope="col" class="text-nowrap">Ship To Company Tax ID</th>
                                                        <th scope="col" class="text-nowrap">Ship To Address Line 1</th>
                                                        <th scope="col" class="text-nowrap">Ship To Address Line 2</th>
                                                        <th scope="col" class="text-nowrap">Ship To City</th>
                                                        <th scope="col" class="text-nowrap">Ship To Postal Code</th>
                                                        <th scope="col" class="text-nowrap">Ship To Country Code</th>

                                                        <th scope="col" class="text-nowrap">Online</th>
                                                        <th scope="col" class="text-nowrap">Customer Online Order Date</th>
                                                        <th scope="col" class="text-nowrap">Sell From ID</th>
                                                        <th scope="col" class="text-nowrap">Product Serial ID assigned by HP</th>

                                                        <th scope="col" class="text-nowrap">Deal/Promo ID #1</th>
                                                        <th scope="col" class="text-nowrap">Bundle ID #1</th>
                                                        <th scope="col" class="text-nowrap">Deal/Promo ID #2</th>
                                                        <th scope="col" class="text-nowrap">Bundle ID#2</th>
                                                        <th scope="col" class="text-nowrap">Deal/Promo ID #3</th>
                                                        <th scope="col" class="text-nowrap">Bundle ID#3</th>
                                                        <th scope="col" class="text-nowrap">Deal/Promo ID #4</th>
                                                        <th scope="col" class="text-nowrap">Bundle ID#4</th>
                                                        <th scope="col" class="text-nowrap">Deal/Promo ID #5</th>
                                                        <th scope="col" class="text-nowrap">Bundle ID#5</th>
                                                        <th scope="col" class="text-nowrap">Deal/Promo ID #6</th>
                                                        <th scope="col" class="text-nowrap">Bundle ID#6</th>

                                                        <th scope="col" class="text-nowrap">Contract ID</th>
                                                        <th scope="col" class="text-nowrap">Contract start date</th>
                                                        <th scope="col" class="text-nowrap">Contract end date</th>
                                                        <th scope="col" class="text-nowrap">Drop ship Flag</th>
                                                        <th scope="col" class="text-nowrap">Partner Internal transaction ID</th>
                                                        <th scope="col" class="text-nowrap">Partner Requested Rebate Amount</th>
                                                        <th scope="col" class="text-nowrap">Partner Reference</th>
                                                        <th scope="col" class="text-nowrap">Partner Comment</th>
                                                        <th scope="col" class="text-nowrap">Partner Product Name</th>

                                                        {{--
                                                        @foreach($report[key($report)] as $key=>$value)
                                                            @if($key != "has_contract")
                                                                <th scope="col" class="text-nowrap">{{ $key }}</th>
                                                            @endif
                                                        @endforeach
                                                        --}}
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @php
                                                        $aId = 0;
                                                        $paId = 0;
                                                        $color1 = 'text-danger';
                                                        $color2 = 'text-primary';
                                                        $rowColor = $color1;
                                                    @endphp

                                                    @foreach($ad->report as $row)
                                                        @php
                                                            $aId = $row->article_id;
                                                            if($aId != $paId) {
                                                                 $rowColor = ($rowColor == $color1) ? $color2 : $color1;
                                                             }
                                                        @endphp

                                                        <tr class="@if($row->has_contract == 0) text-decoration-underline @endif {{ $rowColor }}">

                                                            <td class="text-nowrap">{{ $row->{'Country'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Partner ID'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Partner Name'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Start period'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'End period'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'HP Product Number'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Total Sellin Units'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Inventory Units'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Sales Units'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Transaction Date'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Channel Partner to Customer Invoice ID'} }}</td>

                                                            <td class="text-nowrap">{{ $row->{'Sold-to Customer ID'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Sold To Customer Name'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Sold To Company Tax ID'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Sold To Address Line 1'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Sold To Address Line 2'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Sold To City'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Sold To Postal Code'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Sold To Country Code'} }}</td>

                                                            <td class="text-nowrap">{{ $row->{'Ship-to Customer ID'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Ship To Customer Name'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Ship To Company Tax ID'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Ship To Address Line 1'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Ship To Address Line 2'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Ship To City'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Ship To Postal Code'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Ship To Country Code'} }}</td>

                                                            <td class="text-nowrap">{{ $row->{'Online'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Customer Online Order Date'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Sell From ID'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Product Serial ID assigned by HP'} }}</td>

                                                            <td class="text-nowrap">{{ $row->{'Deal/Promo ID #1'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Bundle ID #1'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Deal/Promo ID #2'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Bundle ID #2'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Deal/Promo ID #3'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Bundle ID #3'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Deal/Promo ID #4'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Bundle ID #4'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Deal/Promo ID #5'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Bundle ID #5'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Deal/Promo ID #6'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Bundle ID #6'} }}</td>

                                                            <td class="text-nowrap">{{ $row->{'Contract ID'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Contract start date'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Contract end date'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Drop ship Flag'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Partner Internal transaction ID'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Partner Requested Rebate Amount'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Partner Reference'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Partner Comment'} }}</td>
                                                            <td class="text-nowrap">{{ $row->{'Partner Product Name'} }}</td>

                                                            {{--
                                                            @foreach($row as $key=>$value)
                                                                @if($key != "has_contract" or $key != "article_id")
                                                                    <td class="text-nowrap">{{ $value }}</td>
                                                                @endif
                                                            @endforeach
                                                            --}}
                                                        </tr>
                                                        @php($paId = $aId)
                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--
                            <div class="table-responsive  table-reports">

                                <table class="table table-sm table-light">
                                    <thead>
                                    <tr class="text-start">
                                        @foreach($ad->headers as $key=>$value)
                                            @if($key != "has_contract")
                                                <th scope="col" class="text-nowrap">{{ $key }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($ad->report as $row)
                                        <tr @if($row->has_contract == 0) class="text-danger" @endif>
                                            @foreach($row as $key=>$value)
                                                @if($key != "has_contract")
                                                    <td class="text-nowrap">{{ $value }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            --}}
                        @endif

                        @if($ad->errors == 500)
                            <div class="alert alert-danger mt-4" id="create_report_message">{{ $ad->message }}</div>
                        @endif

                        @if($ad->errors == 200)
                            <div class="alert alert-success mt-4" id="create_report_message">{{ $ad->message }}</div>
                        @endif


                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

