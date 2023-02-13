@extends('hpreport.index')

@section('hprcontent')
    <div class="container">

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
                            <option value="{{ $report->report_id }}" @if($ad->pReSelected->report_id == $report->report_id) selected @endif >
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
        @endif
        @if($ad->errors == 1)
            <div class="alert alert-danger" id="create_report_message">{{ $ad->message }}</div>
        @endif


    </div>




@endsection

