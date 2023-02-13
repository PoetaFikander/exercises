@extends('hpreport.index')

@section('hprcontent')
    <div class="container">

        <div class="table-responsive">
            {{--@if(isset($reports[0])) --}}
                <table class="table table-striped table-sm table-light table-hover">
                    <thead>
                    <tr class="text-start">
                        <th scope="col" class="text-nowrap">ID raportu</th>
                        <th scope="col" class="text-nowrap">Nr raportu</th>
                        <th scope="col" class="text-nowrap">Nr tygodnia</th>
                        <th scope="col" class="text-nowrap">Rok</th>
                        <th scope="col" class="text-nowrap">ID poprzedniego raportu</th>
                        <th scope="col" class="text-nowrap">Akcje</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $row)
                        <tr data-id="{{ $row->report_id }}">
                            <td class="text-nowrap">{{ $row->report_id }}</td>
                            <td class="text-nowrap">{{ $row->report_no }}</td>
                            <td class="text-nowrap">{{ $row->week_no }}</td>
                            <td class="text-nowrap">{{ $row->year }}</td>
                            <td class="text-nowrap">{{ $row->previous_report_id }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('hpreport.reports.show', $row->report_id) }}"><button class="btn btn-sm"><i class="bi-search"></i></button></a>

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
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            {{--@endif--}}

            {{--
                        @if(isset($reports[0]))
                            <table class="table table-sm table-light table-hover">
                                <thead>
                                <tr class="text-start">
                                    @foreach($reports[0] as $key=>$value)
                                        <th scope="col" class="text-nowrap">{{ $key }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($reports as $row)
                                    <tr
                                        data-toggle="reportsshow"
                                        data-id="{{ $row->{'ID raportu'} }}"
                                    >
                                        @foreach($row as $key=>$value)
                                            <td class="text-nowrap">{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        @endif
            --}}

        </div>

    </div>




@endsection

