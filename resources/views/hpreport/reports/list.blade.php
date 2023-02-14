@extends('hpreport.index')

@section('hprcontent')
    <div class="container">

        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-2">
                                <h4>Lista raportów</h4>
                            </div>
                            <div class="col-md-8"></div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            {{--@if(isset($reports[0])) --}}
                            <table class="table table-striped table-sm table-light table-hover">
                                <thead>
                                <tr class="text-start">
                                    <th scope="col" class="text-nowrap">ID raportu</th>
                                    <th scope="col" class="text-nowrap">Nr raportu</th>
                                    {{--<th scope="col" class="text-nowrap">Nr tygodnia</th>--}}
                                    {{--<th scope="col" class="text-nowrap">Rok</th>--}}
                                    {{--<th scope="col" class="text-nowrap">ID poprzedniego raportu</th>--}}
                                    <th scope="col" class="text-nowrap">Nr poprzedniego raportu</th>
                                    <th scope="col" class="text-nowrap">Akcje</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reports as $row)
                                    <tr data-id="{{ $row->report_id }}">
                                        <td class="text-nowrap">{{ $row->report_id }}</td>
                                        <td class="text-nowrap">{{ $row->report_no }}</td>
                                        {{--<td class="text-nowrap">{{ $row->week_no }}</td>--}}
                                        {{--<td class="text-nowrap">{{ $row->year }}</td>--}}
                                        {{--<td class="text-nowrap">{{ $row->previous_report_id }}</td>--}}
                                        <td class="text-nowrap">{{ $row->previous_report_no }}</td>
                                        <td class="text-nowrap">
                                            <a href="{{ route('hpreport.reports.show', $row->report_id) }}">
                                                <button class="btn btn-sm"><i class="bi-search"></i></button>
                                            </a>

                                            <a href="{{ route('hpreport.reports.edit', $row->report_id) }}">
                                                <button class="btn btn-sm">
                                                    <i class="bi-pencil"></i>
                                                </button>
                                            </a>

                                            <button
                                                class="btn btn-sm"
                                                data-toggle="reportdelete"
                                                data-id="{{ $row->report_id }}"
                                                data-name="{{ $row->report_id }}"
                                            >
                                                <i class="bi-trash"></i>
                                            </button>

                                            <a href="{{ route('hpreport.reports.export', $row->report_id) }}">
                                                <button class="btn btn-sm">
                                                    <i class="bi-download"></i>
                                                </button>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{--@endif--}}

                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

