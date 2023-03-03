@extends('profits.index')

@section('profitcontent')

    <!-- Modal -->

    <div class="modal fade modal-xl" id="showDocModal" tabindex="-1" aria-labelledby="showDocModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="showDocModalLabel"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- modal body --}}
                    <div class="container-fluid">

                        <div class="row">

                            <div class="col-lg-4">

                                <div id="netValue">
                                    <div class="row mb-1">
                                        <label for="netValueInp" class="col-sm-9 col-form-label">Netto</label>
                                        <div class="col-sm-3" style="padding-right: 0;">
                                            <input type="text" class="form-control form-control-sm text-end" id="netValueInp" disabled/>
                                        </div>
                                    </div>
                                </div>

                                <div id="grossValue">
                                    <div class="row mb-1">
                                        <label for="grossValueInp" class="col-sm-9 col-form-label">Brutto</label>
                                        <div class="col-sm-3" style="padding-right: 0;">
                                            <input type="text" class="form-control form-control-sm text-end" id="grossValueInp" disabled/>
                                        </div>
                                    </div>
                                </div>

                                <div id="sourceNo">
                                    <div class="row">
                                        <label for="sourceNoInp" class="col-form-label">Numer obcy</label>
                                    </div>
                                    <div class="row mb-1">
                                        <input type="text" class="form-control form-control-sm" id="sourceNoInp" disabled/>
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="purchaserName" class="col-form-label">Nabywca</label>
                                </div>
                                <div class="row mb-1">
                                    <input type="text" class="form-control form-control-sm" id="purchaserName" disabled/>
                                </div>

                                <div class="row">
                                    <label for="recipientName" class="col-form-label">Odbiorca</label>
                                </div>
                                <div class="row mb-1">
                                    <input type="text" class="form-control form-control-sm" id="recipientName" disabled/>
                                </div>


                                <div class="row d">
                                    <label for="docDate" class="col-form-label col-sm-6">Data wystawienia</label>
                                    <label for="docSellingDate" class="col-form-label col-sm-6">Data sprzedaży</label>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-sm-6" style="padding-left: 0;">
                                        <input type="text" class="form-control form-control-sm" id="docDate" disabled/>
                                    </div>
                                    <div class="col-sm-6" style="padding-right: 0;">
                                        <input type="text" class="form-control form-control-sm" id="docSellingDate" disabled/>
                                    </div>
                                </div>

                                <div id="docDate3div" class="d-none">
                                    <div class="row">
                                        <label for="docDate3" class="col-form-label col-sm-6">Data realizacji</label>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-sm-6" style="padding-left: 0;">
                                            <input type="text" class="form-control form-control-sm" id="docDate3" disabled/>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <label for="sourceStoreName" class="col-form-label">Magazyn</label>
                                </div>
                                <div class="row mb-1">
                                    <input type="text" class="form-control form-control-sm" id="sourceStoreName" disabled/>
                                </div>

                                <div class="row">
                                    <label for="paymentFormName" class="col-form-label col-sm-6">Płatność</label>
                                    <label for="paymentDate" class="col-form-label col-sm-6">Termin</label>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-sm-6" style="padding-left: 0;">
                                        <input type="text" class="form-control form-control-sm" id="paymentFormName" disabled/>
                                    </div>
                                    <div class="col-sm-6" style="padding-right: 0;">
                                        <input type="text" class="form-control form-control-sm" id="paymentDate" disabled/>
                                    </div>
                                </div>

                                <div class="row">
                                    <label for="companyUnitName" class="col-form-label col-sm-6">Właściciel</label>
                                    <label for="docAssistant" class="col-form-label col-sm-6">Obsługujący</label>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-sm-6" style="padding-left: 0;">
                                        <input type="text" class="form-control form-control-sm" id="companyUnitName" disabled/>
                                    </div>
                                    <div class="col-sm-6" style="padding-right: 0;">
                                        <input type="text" class="form-control form-control-sm" id="docAssistant" disabled/>
                                    </div>
                                </div>


                            </div>
                            <div class="col-lg-8">

                                <div class="table-responsive">
                                    <table class="table table-striped table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">Lp</th>
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
                    {{-- end modal body --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <!-- end Modal -->


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

                                <div class="d-inline-block ms-3">
                                    <h6>Okres obowiązywania od:&nbsp;</h6>
                                </div>
                                <div class="d-inline-block">
                                    <h5>{{ $device->agreement_data_start }}</h5>
                                </div>
                                <div class="d-inline-block ms-1">
                                    <h6>do:&nbsp;</h6>
                                </div>
                                <div class="d-inline-block">
                                    <h5>{{ $device->agreement_data_end }}</h5>
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
                                            <span class="fs-5">Zlecenia</span>
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
                                            <span class="fs-5">Wydania do zleceń</span>
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
                                    <h2 class="accordion-header" id="headingNine">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine"
                                                aria-expanded="false" aria-controls="collapseNine">
                                            <span class="fs-5">Podsumowanie artykułów z WZ</span>
                                        </button>
                                    </h2>
                                    <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="WZContentsSumTable">
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


                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                            <span class="fs-5">Artykuły ze zleceń bezpłatnych</span>
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="costTable">
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
                                            <span class="fs-5">Artykuły ze zleceń płatnych</span>
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="incomeTable">
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
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                aria-expanded="false" aria-controls="collapseFive">
                                            <span class="fs-5">FS do kontraktu</span>
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover profit-summary" id="FSTable">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Id</th>
                                                        <th scope="col">Numer</th>
                                                        <th scope="col">Data</th>
                                                        <th scope="col">Wartość</th>
                                                        <th scope="col"></th>
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
                                            <span class="fs-5">Usługi z FS</span>
                                        </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
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
                                    <h2 class="accordion-header" id="headingSeven">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven"
                                                aria-expanded="false" aria-controls="collapseSeven">
                                            <span class="fs-5">Podsumowanie usług z FS</span>
                                        </button>
                                    </h2>
                                    <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
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


                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingEight">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight"
                                                aria-expanded="false" aria-controls="collapseEight">
                                            <span class="fw-bold fs-5">Podsumowanie urządzenia</span>
                                        </button>
                                    </h2>
                                    <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="summaryTable">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col"></th>
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

