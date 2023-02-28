@extends('profits.index')

@section('profitcontent')


    <div class="container" id="deviceProfit">


        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-inline-block">
                                    <h6>Profit urządzenia:&nbsp;</h6>
                                </div>
                                <div class="d-inline-block">
                                    <h4>{{ $device->dev_name }}</h4>
                                </div>
                                <div class="d-inline-block ms-3">
                                    <h6>nr ser.&nbsp;</h6>
                                </div>
                                <div class="d-sm-inline-block">
                                    <h4>{{ $device->dev_serial_no }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="d-inline-block">
                                    <h6>Kontrahent:&nbsp;</h6>
                                </div>
                                <div class="d-inline-block">
                                    <h5>{{ $device->customer_name }}</h5>
                                </div>
                                <div class="d-inline-block ms-3">
                                    <h6>Umowa:&nbsp;</h6>
                                </div>
                                <div class="d-inline-block">
                                    <h5>{{ $device->agreement_no }}</h5>
                                </div>
                                <div class="d-inline-block ms-3">
                                    <h6>Status:&nbsp;</h6>
                                </div>
                                <div class="d-inline-block">
                                    <h5>{{ $device->agreement_status }}</h5>
                                </div>

                            </div>
                        </div>


                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">

                                <div class="d-inline-block">
                                    <label for="profitDateFrom">Okres od:&nbsp;</label>
                                </div>
                                <div class="d-inline-block">
                                    <input type='text' value="{{ $device->fdom }}" class="form-control form-control-sm fs-5 input-datepicker"
                                           id='profitDateFrom'>
                                </div>

                                <div class="d-inline-block ms-2">
                                    <label for="profitDateTo">do:&nbsp;</label>
                                </div>
                                <div class="d-inline-block">
                                    <input type='text' value="{{ $device->ldom }}" class="form-control form-control-sm fs-5 input-datepicker"
                                           id='profitDateTo'>
                                </div>

                                <div class="d-inline-block ms-2">
                                    <button type="button" class="btn btn-outline-primary" id="btnShowProfit" data-devid="{{ $device->dev_id }}"
                                            data-agrid="{{ $agrId }}"><i class="bi bi-currency-dollar fs-6"></i></button>
                                </div>

                            </div>

                        </div>


                        <div class="row">


                            <div class="accordion mt-3 _d-none" id="accordionExample">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne">
                                            Zlecenia
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="workCardTable">
                                                    <thead>
                                                    <tr>
                                                        {{--<th scope="col">Id</th>--}}
                                                        <th scope="col">Numer</th>
                                                        <th scope="col">Obsługujący</th>
                                                        <th scope="col">Data</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                            Wydania
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="docTable">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col" class="col-1">ZL</th>
                                                        <th scope="col" class="col-1">ZS</th>
                                                        <th scope="col" class="col-1">WZ</th>
                                                        <th scope="col" class="col-1">FS</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                            Artykuły z WZ
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="artTable">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Data WZ</th>
                                                        <th scope="col">Numer WZ</th>
                                                        <th scope="col">Kod</th>
                                                        <th scope="col">Nazwa</th>
                                                        <th scope="col">Ilość</th>
                                                        <th scope="col">Cena</th>
                                                        <th scope="col">Wartość</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                aria-expanded="false" aria-controls="collapseFour">
                                            Faktury do kontraktów
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="FSTable">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Id</th>
                                                        <th scope="col">Numer</th>
                                                        <th scope="col">Data</th>
                                                        <th scope="col">Wartość</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                aria-expanded="false" aria-controls="collapseFive">
                                            Usługi z FS
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="FSContentsTable">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Lp.</th>
                                                        <th scope="col">Data FS</th>
                                                        <th scope="col">Numer FS</th>
                                                        <th scope="col">Kod artykułu</th>
                                                        <th scope="col">Nazwa artykułu</th>
                                                        <th scope="col">Ilość</th>
                                                        <th scope="col">Cena</th>
                                                        <th scope="col">Wartość</th>
                                                        <th scope="col">Licznik</th>
                                                        <th scope="col">Podlega</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSix">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                                aria-expanded="false" aria-controls="collapseSix">
                                            Podsumowanie usług z faktur
                                        </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="FSContentsSumTable">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Kod</th>
                                                        <th scope="col">Nazwa</th>
                                                        <th scope="col">Ilość</th>
                                                        <th scope="col">Wartość</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>

    </div>
@endsection

