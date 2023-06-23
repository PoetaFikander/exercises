@extends('bok.index')

@section('bokcontent')

    <div class="container" id="bok-review">

    <!-- Modal deviceInfo -->
    {{--@include('bok.review.modal')--}}
    @include('modals.deviceInfo')
    <!-- end Modal deviceInfo -->

    <!-- Modal workCard -->
    @include('modals.workCard')
    <!-- end Modal workCard -->

        <!-- review content -->
        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="d-inline-block col-md-4">
                                <h5>Przeglądy</h5>
                            </div>
                            <div class="d-inline-block col-md-4">
                                <div class="result-message text-center"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" id="review-container">


                        <div class="row mb-2">
                            <div class="d-inline-block col-md-12">

                                <div class="input-group">

                                    <div class="px-2 py-2 col-md-3">
                                        <div class="d-inline me-3">
                                            <label class="">Data gwarancji:</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radio-options-1" id="radio-yes-1" value="1"
                                                   checked="checked">
                                            <label class="form-check-label" for="radio-yes-1">tak</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radio-options-1" id="radio-no-1" value="0">
                                            <label class="form-check-label" for="radio-no-1">nie</label>
                                        </div>
                                    </div>

                                    <div class="px-2 py-2 col-md-3">
                                        <div class="d-inline me-3">
                                            <label class="">Na gwarancji:</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radio-options-2" id="radio-yes-2" value="1"
                                                   checked="checked">
                                            <label class="form-check-label" for="radio-yes-2">tak</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radio-options-2" id="radio-no-2" value="0">
                                            <label class="form-check-label" for="radio-no-2">nie</label>
                                        </div>
                                    </div>

                                    <div class="col-md-2 py-2 text-end">
                                        <div class="d-inline me-3">
                                            <label class="">Przegląd wyznaczony na:</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group">

                                            <label class="input-group-text">Rok</label>
                                            <select class="form-select" name="year">
                                                <option value="0">--- Nie wybrano ---</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                            </select>

                                            <label class="input-group-text">Miesiąc</label>
                                            <select class="form-select" name="month">
                                                <option value="0">--- Nie wybrano ---</option>
                                                <option value="1">styczeń</option>
                                                <option value="2">luty</option>
                                                <option value="3">marzec</option>
                                                <option value="4">kwiecień</option>
                                                <option value="5">maj</option>
                                                <option value="6">czerwiec</option>
                                                <option value="7">lipiec</option>
                                                <option value="8">sierpień</option>
                                                <option value="9">wrzesień</option>
                                                <option value="10">październik</option>
                                                <option value="11">listopad</option>
                                                <option value="12">grudzień</option>
                                            </select>

                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>


                        <div class="row">
                            <div class="d-inline-block col-md-12">
                                <div class="input-group">

                                    <label class="input-group-text">Oddział</label>
                                    <select class="form-select" name="department">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($departments as $d)
                                            <option value="{{ $d->altum_id }}">{{ $d->name }}</option>
                                        @endforeach
                                    </select>

                                    <label class="input-group-text">Typ umowy</label>
                                    <select class="form-select" name="agr-type">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($agrTypes as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>

                                    <label class="input-group-text">Technik</label>
                                    <select class="form-select" name="technician">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($technicians as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="btn btn-outline-secondary" id="btn-search"><i class="bi bi-search"></i></button>

                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="table-responsive mt-3 pt-1">
                                <table class="table table-striped table-sm table-hover" id="deviceTable">
                                    <thead>
                                    <tr>
                                        <th scope="col">Nazwa</th>
                                        <th scope="col">Nr seryjny</th>
                                        <th scope="col">Kontrahent</th>
                                        {{--<th scope="col">Technik</th>--}}
                                        <th scope="col">Oddział</th>
                                        <th scope="col">Gwarancja do</th>
                                        <th scope="col">Ost. przegląd</th>
                                        <th scope="col">Dni</th>
                                        <th scope="col">Nast. przegląd</th>
                                        <th scope="col">Otwarte zlecenie</th>
                                        {{--<th scope="col">Adres</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!-- end review content -->

    </div>
@endsection

