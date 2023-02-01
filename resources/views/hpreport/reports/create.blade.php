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
                            @if($ad->weekDays->year == $year) selected @endif
                        >
                            {{ $year }}
                        </option>
                    @endforeach
                </select>

                <label class="my-1 me-2" for="for_week">Tydzień</label>
                <select class="form-select my-1 me-sm-2 w-auto" id="for_week" name="for_week" data-toggle="h_r_c_for_week">
                    @foreach($ad->weeks as $week)
                        <option
                            data-from="{{ $week->w_start }}"
                            value="{{ $week->w_start }}"
                            @if($week->w_no == $ad->weekDays->w_no) selected @endif
                        >
                            {{ $week->w_start . ' - ' . $week->w_end }}
                        </option>
                    @endforeach
                </select>

                <label class="my-1 me-2" for="for_reportid">Raport nr</label>
                <select class="form-select my-1 me-sm-2 w-auto" id="for_reportno" name="for_reportid" data-toggle="h_r_c_for_reportid">
                    @foreach($ad->lastReports as $report)
                        <option value="{{ $report->report_id }}">
                            {{ $report->report_no }}
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
                    @foreach($ad->headers as $key=>$value)
                        <th scope="col" class="text-nowrap">{{ $key }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>

                @foreach($ad->data as $row)
                    <tr>
                        @foreach($row as $key=>$value)
                            <td class="text-nowrap">{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    </div>




@endsection

