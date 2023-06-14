@extends('bok.index')

@section('bokcontent')

    <div class="container" id="bok-devices">

        @include('bok.devices.modal')

        <div class="row">
            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            {{--<div class="col-md-12" id="">--}}
                                <div class="d-inline-block col-md-4">
                                    <h5>Urządzenia</h5>
                                </div>
                                <div class="d-inline-block col-md-4">
                                    <div class="result-message text-center"></div>
                                </div>
                            {{--</div>--}}
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            @include('bok.devices.accordion')

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection

