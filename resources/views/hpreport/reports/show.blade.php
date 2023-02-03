@extends('hpreport.index')

@section('hprcontent')
    <div class="container">


        <div class="table-responsive table-reports">

            <table class="table table-sm table-light">
                <thead>
                <tr class="text-start">
                    @foreach($report[0] as $key=>$value)
                        <th scope="col" class="text-nowrap">{{ $key }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>

                @foreach($report as $row)
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

