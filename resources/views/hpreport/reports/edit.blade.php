@extends('hpreport.index')

@section('hprcontent')
    <div class="container">

        <div class="row">

            <div class="col-md-12 py-2">
                <div class="card">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-md-2">
                                <h4>Raport {{ $reportNo }}</h4>
                            </div>
                            <div class="col-md-8" data-toggle="hre_reportupdatemessage"></div>
                            <div class="col-md-2">
                                <a href="#" class="btn btn-primary float-end" data-toggle="hre_reportupdate">Zapisz zmiany</a>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="table-responsive table-reports">

                            <table class="table table-sm table-hover my-table" id="h_r_e_table">

                                <thead>
                                <tr class="text-start">
                                    @foreach($report[key($report)] as $key=>$value)
                                        @if($key != 'row_type' and $key != 'is_article_first_row')
                                            @if($key === 'row_status')
                                                <th scope="col" class="text-nowrap"></th>
                                            @else
                                                <th scope="col" class="text-nowrap">{{ $key }}</th>
                                            @endif
                                        @endif
                                    @endforeach
                                </tr>
                                </thead>

                                <tbody>

                                @php
                                    $aId = 0;
                                    $paId = 0;
                                    $color1 = 'text-danger';
                                    $color2 = 'text-primary';
                                    $rowColor = $color1;
                                    $change = false;
                                @endphp

                                @foreach($report as $row)

                                    @php
                                        $aId = $row->article_id;
                                        if($aId != $paId) {
                                             $rowColor = ($rowColor == $color1) ? $color2 : $color1;
                                             $change = true;
                                         }
                                    @endphp

                                    <tr data-id="{{ $row->id }}"
                                        data-artid="{{ $aId }}"
                                        data-preiu="{{ $row->previous_iu}}"
                                        data-totsu="{{ $row->total_su }}"
                                        class="{{ $rowColor }}"
                                    >
                                        @foreach($row as $key=>$value)
                                            @if($key != 'row_type' and $key != 'is_article_first_row')

                                                @switch($key)

                                                    @case('Total Sellin Units')
                                                    <td class="text-nowrap">
                                                        <input type="number"
                                                               data-id="{{ $row->id }}"
                                                               data-artid="{{ $aId }}"
                                                               data-toggle="artInpNumber"
                                                               data-prevval="{{ $value }}"
                                                               value="{{ $value }}"
                                                               @if(!$row->is_article_first_row or $row->row_type > 2) disabled @endif
                                                               name="tsu" min="-100" max="100">
                                                    </td>
                                                    @break

                                                    @case('Inventory Units')
                                                    <td class="text-nowrap">
                                                        <input type="number"
                                                               data-id="{{ $row->id }}"
                                                               data-artid="{{ $aId }}"
                                                               data-toggle="artInpNumber"
                                                               data-prevval="{{ $value }}"
                                                               value="{{ $value }}"
                                                               @if(!$row->is_article_first_row) disabled @endif
                                                               name="iu" min="0" max="10000">
                                                    </td>
                                                    @break

                                                    @case('Sales Units')
                                                    <td class="text-nowrap">
                                                        <input type="number"
                                                               data-id="{{ $row->id }}"
                                                               data-artid="{{ $aId }}"
                                                               data-prevval="{{ $value }}"
                                                               value="{{ $value }}"
                                                               @if((!$row->is_article_first_row and $row->row_type != 1) or $row->row_type != 1)
                                                               disabled
                                                               @endif
                                                               data-toggle="artInpNumber" name="su" min="-100" max="100">
                                                    </td>
                                                    @break

                                                    @default

                                                    @if($key === 'row_status')
                                                        <td class="text-nowrap">
                                                            <input type="hidden" value="{{ $value }}">
                                                            <span class="row-status">
                                                                @if($row->is_cohesive == 0)
                                                                    <i class="text-danger bi bi-exclamation-triangle fs-5 fw-bold"></i>
                                                                @endif
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td class="text-nowrap">{{ $value }}</td>
                                                    @endif

                                                @endswitch

                                            @endif
                                        @endforeach
                                    </tr>

                                    @php($paId = $aId)
                                    @php($change = false)

                                @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>




@endsection

