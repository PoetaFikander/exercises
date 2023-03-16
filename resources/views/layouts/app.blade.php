<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet">

    <!-- My Scripts -->
    {{--
        <script src="{{ asset('js/main.js') }}" defer></script>
    --}}

</head>
<body>
<div id="app">

    <div id="overlay-spinner">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <!-- ------------------ MODALE ------------------------------  -->


    <!-- Modal agreement profit progress -->
    <div class="modal fade" id="contractProfitProgressModal"
         data-bs-backdrop="static"
         data-bs-keyboard="false"
         tabindex="-1"
         aria-labelledby="profitProgressLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-xl">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="showWorkCardModalLabel">Obliczanie profitu umowy</h5>
                </div> <!-- end modal-header -->

                <div class="modal-body">

                    <div class="container-fluid">
                        <div class="row w-100"><h5 class="progress-label text-center"></h5></div>
                        <div class="row mt-2 progress" style="height: 25px;" role="progressbar" aria-label="progressbar" aria-valuenow="0"
                             aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar fs-6" style="padding-top: 3px;"></div>
                        </div>
                    </div>

                </div> <!-- end modal-body -->

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Zakończ
                    </button>
                </div> <!-- end modal-footer -->

            </div> <!-- end modal-content -->

        </div> <!-- end modal-dialog -->

    </div> <!-- end Modal agreement profit progress -->


    <!-- Modal zlecenia z Altum -->

    <div class="modal fade" id="showWorkCardModal" tabindex="-1" aria-labelledby="showWorkCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
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
                                                <input type="text" style="margin-left: 3px;" class="form-control form-control-sm" id="datePaymentImp"
                                                       disabled/>
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

    <!-- ------------------ END MODALE --------------------------  -->


    <nav class="navbar navbar-expand-md navbar-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                    {{--@can('isAdmin','isHPReports')
                    @can('isHPReports')
                        <a class="nav-link" href="{{ route('hpreport.index') }}">Raport HP</a>
                    @endcan
                    --}}

                    @canany(['isAdmin', 'isHPReports'])
                        <a class="nav-link" href="{{ route('hpreport.index') }}">Raport HP</a>
                        <!-- The current user can update, view, or delete the post... -->
                        {{--@elsecanany(['create'], \App\Models\Post::class)--}}
                    <!-- The current user can create a post... -->
                    @endcanany

                    @canany(['isAdmin', 'isProfits'])
                        <a class="nav-link" href="{{ route('profits.index') }}">Profitowość</a>
                    @endcanany

                    @can('isAdmin')
                        <a class="nav-link" href="{{ route('users.list') }}">Użytkownicy</a>
                    @endcan
                    {{--<a class="nav-link" href="{{ route('users.list') }}">{{ __('Użytkownicy') }}</a>--}}
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-0">
        @yield('content')
    </main>
</div>

<script src="{{ asset('DataTables/datatables.min.js') }}" defer></script>
<script src="{{ asset('Datepicker/bootstrap-datepicker.min.js') }}" defer></script>
<script src="{{ asset('js/main.js') }}" defer></script>

<script type="module">
    @yield('js')
</script>
@yield('js-files')

</body>
</html>
