@extends('layouts.app')

@section('content')

    <div class="container">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('profits.index') }}">Profitowość</a>

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('profits.devices.list') }}">Urządzenia</a>
                        </li>

                        @can('isAdmin')
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('profits.contracts.list') }}">Umowy</a>
                        </li>
                        @endcan

                        {{--
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('hpreport.customers.list') }}">Kontrahenci</a>
                        </li>
                        --}}

                    </ul>
                </div>
            </div>
        </nav>

        <div class="py-0">

            <!-- Modal zlecenia z Altum -->

            <div class="modal fade modal-xl" id="showWorkCardModal" tabindex="-1" aria-labelledby="showWorkCardModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="showWorkCardModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div> <!-- end modal-header -->
                        <div class="modal-body">

                            <div class="container-fluid">

                                <div class="row">

                                    <div class="col-lg-3">

                                        <div id="statusName" class="ltop">
                                            <div class="row">
                                                <label for="statusNameInp" class="col-form-label">Status</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="statusNameInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="devName" class="ltop">
                                            <div class="row">
                                                <label for="devNameInp" class="col-form-label">Nazwa urządzenia</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="devNameInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="devSerialNo" class="ltop">
                                            <div class="row">
                                                <label for="devSerialNoInp" class="col-form-label">Nr seryjny urządzenia</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="devSerialNoInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="lastModificationDate" class="ltop">
                                            <div class="row">
                                                <label for="lastModificationDateInp" class="col-form-label">Data ostatnich zmian</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="lastModificationDateInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="servicePersonName" class="ltop">
                                            <div class="row">
                                                <label for="servicePersonNameInp" class="col-form-label">Technik</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="servicePersonNameInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="faultTypeName" class="ltop">
                                            <div class="row">
                                                <label for="faultTypeNameInp" class="col-form-label">Rodzaj usterki</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="faultTypeNameInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="priorityName" class="ltop">
                                            <div class="row">
                                                <label for="priorityNameInp" class="col-form-label">Priorytet</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="priorityNameInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="typeName" class="ltop">
                                            <div class="row">
                                                <label for="typeNameInp" class="col-form-label">Forma rozliczenia</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="typeNameInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="plannedRealizationTerm" class="ltop">
                                            <div class="row">
                                                <label for="plannedRealizationTermInp" class="col-form-label">Planowana data realizacji</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="plannedRealizationTermInp" disabled/>
                                            </div>
                                        </div>

                                    </div> <!-- end col-lg-3 -->

                                    <div class="col-lg-9">

                                        <div class="container-fluid">

                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a href="#tabOne" class="nav-link active" data-bs-toggle="tab">Opisy</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tabTwo" class="nav-link" data-bs-toggle="tab">Parametry</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tabThree" class="nav-link" data-bs-toggle="tab">Rejestr czynności</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tabFour" class="nav-link" data-bs-toggle="tab">Materiały</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tabFive" class="nav-link" data-bs-toggle="tab">Usługi</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tabSix" class="nav-link" data-bs-toggle="tab">Dokumenty</a>
                                                </li>

                                            </ul>

                                            <div class="tab-content">

                                                <div class="tab-pane fade show active" id="tabOne">

                                                    <div id="faultDescription">
                                                        <div class="row">
                                                            <label for="faultDescriptionInp" class="col-form-label">Opis usterki</label>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <textarea class="form-control form-control-sm" id="faultDescriptionInp" rows="16" disabled></textarea>
                                                        </div>
                                                    </div>

                                                    <div id="agrDescription">
                                                        <div class="row">
                                                            <label for="agrDescriptionInp" class="col-form-label">Dodatkowe ustalenia z umowy</label>
                                                        </div>
                                                        <div class="row mb-1">
                                                            <textarea class="form-control form-control-sm" id="agrDescriptionInp" rows="5" disabled></textarea>
                                                        </div>
                                                    </div>

                                                </div> <!-- end tabOne -->

                                                <div class="tab-pane fade" id="tabTwo">

                                                    <div class="row">

                                                        <div class="col-sm-6">
                                                            <fieldset class="border rounded-2 p-3">
                                                                <legend class="float-none w-auto px-3 fs-6">Naprawa</legend>

                                                                <div class="row mb-1">
                                                                    <label for="wasDeviceWorking" class="col-sm-7 col-form-label">Czy urządzenie działało?</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="checkbox" id="wasDeviceWorking"/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="isDeviceWorking" class="col-sm-7 col-form-label">Czy urządzenie działa?</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="checkbox" id="isDeviceWorking"/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="testCopiesAmount" class="col-sm-7 col-form-label">Ilość kopii testowych</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="testCopiesAmount" class="form-control form-control-sm" disabled/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="drivingDistance" class="col-sm-7 col-form-label">Dojazd (km)</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="drivingDistance" class="form-control form-control-sm" disabled/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="totalTime" class="col-sm-7 col-form-label">Czas całkowity</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="totalTime" class="form-control form-control-sm" disabled/>
                                                                    </div>
                                                                </div>

                                                            </fieldset>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <fieldset class="border rounded-2 p-3">
                                                                <legend class="float-none w-auto px-3 fs-6">SLA</legend>

                                                                <div class="row mb-1">
                                                                    <label for="counterReadingTypeName" class="col-sm-7 col-form-label">Sposób odczytu
                                                                        liczników</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="counterReadingTypeName" class="form-control form-control-sm"
                                                                               disabled/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="replacementPartsName" class="col-sm-7 col-form-label">Części zamienne</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="replacementPartsName" class="form-control form-control-sm"
                                                                               disabled/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="clientWorkTime" class="col-sm-7 col-form-label">Godziny pracy klienta</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="clientWorkTime" class="form-control form-control-sm" disabled/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="clientActualWorkTime" class="col-sm-7 col-form-label">Faktyczny czas pracy
                                                                        klienta</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="clientActualWorkTime" class="form-control form-control-sm"
                                                                               disabled/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="warrantyProducer" class="col-sm-7 col-form-label">Gwarancja producenta</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="warrantyProducer" class="form-control form-control-sm" disabled/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="warrantyDks" class="col-sm-7 col-form-label">Gwarancja DKS</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="warrantyDks" class="form-control form-control-sm" disabled/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="reactionTime" class="col-sm-7 col-form-label">Zadeklarowany czas reakcji</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="reactionTime" class="form-control form-control-sm" disabled/>
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-1">
                                                                    <label for="repairTime" class="col-sm-7 col-form-label">Zadeklarowany czas naprawy</label>
                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="repairTime" class="form-control form-control-sm" disabled/>
                                                                    </div>
                                                                </div>

                                                            </fieldset>
                                                        </div>
                                                    </div>


                                                </div> <!-- end tabTwo -->

                                                <div class="tab-pane fade" id="tabThree">

                                                    <table class="table table-striped" id="wcActionTable">
                                                        <thead>
                                                        <tr>
                                                            <th>Czynność</th>
                                                            <th>Data rozpoczęcia</th>
                                                            <th>Data zakończenia</th>
                                                            <th>Opis/Dane dodatkowe</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>

                                                </div> <!-- end tabThree -->

                                                <div class="tab-pane fade" id="tabFour">

                                                    <table class="table table-striped" id="wcMaterialTable">
                                                        <thead>
                                                        <tr>
                                                            <th>Kod</th>
                                                            <th>Nazwa</th>
                                                            <th>Zamówiono</th>
                                                            <th>Zrealizowano</th>
                                                            <th>Zużyto</th>
                                                            <th>Cena</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>

                                                </div> <!-- end tabFour -->

                                                <div class="tab-pane fade" id="tabFive">

                                                    <table class="table table-striped" id="wcServiceTable">
                                                        <thead>
                                                        <tr>
                                                            <th>Kod</th>
                                                            <th>Nazwa</th>
                                                            <th>Ilość</th>
                                                            <th>Cena</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>

                                                </div> <!-- end tabFive -->

                                                <div class="tab-pane fade" id="tabSix">

                                                    <table class="table table-striped" id="wcDocumentTable">
                                                        <thead>
                                                        <tr>
                                                            <th>Numer</th>
                                                            <th>Data</th>
                                                            <th>Kontrahent</th>
                                                            <th>Wartość netto</th>
                                                            <th>Status</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>

                                                </div> <!-- end tabSix -->

                                            </div>

                                        </div>

                                    </div> <!-- end col-lg-9 -->

                                </div> <!-- end row -->

                            </div> <!-- end container-fluid -->


                        </div> <!-- end modal-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                        </div> <!-- end modal-footer -->
                    </div> <!-- end modal-content -->
                </div> <!-- end modal-dialog -->
            </div> <!-- end Modal zlecenia z Altum -->

            <!-- end Modal zlecenia z Altum -->


            <!-- Modal dokumenty z Altum -->

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
                                                <label for="netValueInp" class="col-sm-6 col-form-label">Netto</label>
                                                <div class="col-sm-6" style="padding-right: 0;">
                                                    <input type="text" class="form-control form-control-sm text-end" id="netValueInp" disabled/>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="grossValue">
                                            <div class="row mb-1">
                                                <label for="grossValueInp" class="col-sm-6 col-form-label">Brutto</label>
                                                <div class="col-sm-6" style="padding-right: 0;">
                                                    <input type="text" class="form-control form-control-sm text-end" id="grossValueInp" disabled/>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="sourceNo" class="ltop">
                                            <div class="row">
                                                <label for="sourceNoInp" class="col-form-label">Numer obcy</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="sourceNoInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="customer1" class="ltop">
                                            <div class="row">
                                                <label for="customer1Inp" class="col-form-label">Nabywca</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="customer1Inp" disabled/>
                                            </div>
                                        </div>

                                        <div id="customer2" class="ltop">
                                            <div class="row">
                                                <label for="customer2Inp" class="col-form-label">Odbiorca</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="customer2Inp" disabled/>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div id="date1" class="ltop">
                                                    <div class="row">
                                                        <label for="date1Inp" class="col-form-label">Data</label>
                                                    </div>
                                                    <div class="row mb-1">
                                                        <input type="text" class="form-control form-control-sm" id="date1Inp" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<div class="col-sm-2"></div>--}}

                                            <div class="col-sm-6">
                                                <div id="date2" class="ltop">
                                                    <div class="row">
                                                        <label for="date2Inp" class="col-form-label">Data</label>
                                                    </div>
                                                    <div class="row mb-1">
                                                        <input type="text" style="margin-left: 3px;" class="form-control form-control-sm" id="date2Inp" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div id="date3" class="ltop">
                                                    <div class="row">
                                                        <label for="date3Inp" class="col-form-label">Data</label>
                                                    </div>
                                                    <div class="row mb-1">
                                                        <input type="text" class="form-control form-control-sm" id="date3Inp" disabled/>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div id="store1" class="ltop">
                                            <div class="row">
                                                <label for="store1Inp" class="col-form-label">Magazyn</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="store1Inp" disabled/>
                                            </div>
                                        </div>

                                        <div id="store2" class="ltop">
                                            <div class="row">
                                                <label for="store2Inp" class="col-form-label">Magazyn</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="store2Inp" disabled/>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div id="paymentFormName" class="ltop">
                                                    <div class="row">
                                                        <label for="paymentFormNameInp" class="col-form-label">Płatność</label>
                                                    </div>
                                                    <div class="row mb-1">
                                                        <input type="text" class="form-control form-control-sm" id="paymentFormNameInp" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div id="datePayment" class="ltop">
                                                    <div class="row">
                                                        <label for="datePaymentImp" class="col-form-label">Termin</label>
                                                    </div>
                                                    <div class="row mb-1">
                                                        <input type="text" style="margin-left: 3px;" class="form-control form-control-sm" id="datePaymentImp" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="companyUnitName" class="ltop">
                                            <div class="row">
                                                <label for="companyUnitNameInp" class="col-form-label">Właściciel</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="companyUnitNameInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="assistant" class="ltop">
                                            <div class="row">
                                                <label for="assistantInp" class="col-form-label">Obsługujący</label>
                                            </div>
                                            <div class="row mb-1">
                                                <input type="text" class="form-control form-control-sm" id="assistantInp" disabled/>
                                            </div>
                                        </div>

                                        <div id="description" class="ltop">
                                            <div class="row">
                                                <label for="descriptionInp" class="col-form-label">Opis</label>
                                            </div>
                                            <div class="row mb-1">
                                                <textarea class="form-control form-control-sm" id="descriptionInp" rows="3" disabled></textarea>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-lg-8">

                                        <div class="container-fluid">
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

                            </div> {{-- end modal body --}}


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end Modal dokumenty z Altum -->



            @yield('profitcontent')
        </div>

    </div>

@endsection

@section('js')
@endsection

@section('js-files')
    {{--
        <script src="{{ asset('js/hpreport.js') }}" defer></script>
    --}}

@endsection


