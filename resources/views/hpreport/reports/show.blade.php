@extends('hpreport.index')

@section('hprcontent')
    <div class="container">


        <div class="table-responsive table-reports">

            <table class="table table-sm table-hover my-table">
                <thead>
                <tr class="text-start">
                    @foreach($report[0] as $key=>$value)
                        @if($key != "has_contract")
                            <th scope="col" class="text-nowrap">{{ $key }}</th>
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
                @endphp

                @foreach($report as $row)

                    @php
                        $aId = $row->article_id;
                        if($aId != $paId) {
                             $rowColor = ($rowColor == $color1) ? $color2 : $color1;
                         }
                    @endphp

                    <tr class="@if($row->has_contract == 0) _text-decoration-underline @endif {{ $rowColor }}">
                        @foreach($row as $key=>$value)
                            @if($key != "has_contract" or $key != "article_id")
                                <td class="text-nowrap">{{ $value }}</td>
                            @endif
                        @endforeach
                    </tr>
                    @php($paId = $aId)
                @endforeach

                </tbody>
            </table>
        </div>


    </div>




@endsection

