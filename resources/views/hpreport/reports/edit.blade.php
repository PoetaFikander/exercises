@extends('hpreport.index')

@section('hprcontent')
    <div class="container">


        <div class="table-responsive table-reports">

            <table class="table table-sm table-hover my-table" id="h_r_e_table">

                <thead>
                <tr class="text-start">
                    @foreach($report[0] as $key=>$value)
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
                                               @if((!$row->is_article_first_row and $row->row_type != 1) or $row->row_type != 1)  disabled @endif
                                               data-toggle="artInpNumber" name="su" min="-100" max="100">
                                    </td>
                                    @break

                                    @default

                                    @if($key === 'row_status')
                                        <td class="text-nowrap row-status"></td>
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




@endsection

