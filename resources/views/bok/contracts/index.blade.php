@extends('bok.index')

@section('bokcontent')

    <div class="container" id="">

        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12" id="">

                                <div class="d-inline-block">
                                    <h5>Umowy</h5>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            @include('bok.contracts.accordion')
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

