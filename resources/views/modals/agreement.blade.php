<!-- Modal umowa serwisowa -->

<div class="modal fade" id="showAgreementModal" tabindex="-1" aria-labelledby="showWorkCardModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header">
                <h1 class="modal-title fs-5" id="showAgreementModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- end modal-header -->

            <div class="modal-body">

                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="container-fluid">

                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a href="#header" class="nav-link active" data-bs-toggle="tab">Nagłowek</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#parameters" class="nav-link" data-bs-toggle="tab">Parametry</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#devices" class="nav-link" data-bs-toggle="tab">Urządzenia</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#attachments" class="nav-link" data-bs-toggle="tab">Załączniki</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#invoices" class="nav-link" data-bs-toggle="tab">Faktury</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#history" class="nav-link" data-bs-toggle="tab">Historia</a>
                                    </li>

                                </ul>

                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="header">

                                        <div class="row">

                                            <div class="col-sm-8 mt-2">

                                                <div class="row mb-1">
                                                    <label for="externalNumber" class="col-sm-2 col-form-label ps-0 pe-1">Numer obcy</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="externalNumber" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="purchaserName" class="col-sm-2 col-form-label ps-0 pe-1">Nabywca/Płatnik</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="purchaserName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="customerPersonName" class="col-sm-2 col-form-label ps-0 pe-1">Osoba kontaktowa</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="customerPersonName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="recipientName" class="col-sm-2 col-form-label ps-0 pe-1">Odbiorca</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="recipientName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="recipientAddressData" class="col-sm-2 col-form-label ps-0 pe-1">Adres odbiorcy</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="recipientAddressData" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="employeeName" class="col-sm-2 col-form-label ps-0 pe-1">Opiekun</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="employeeName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="dateOfStart" class="col-sm-2 col-form-label ps-0 pe-1">Data wprowadzenia</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="dateOfStart" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="dateOfIssue" class="col-sm-2 col-form-label ps-0 pe-1">Data rozliczania</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="dateOfIssue" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="dateOfEnd" class="col-sm-2 col-form-label ps-0 pe-1">Data zakończenia</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="dateOfEnd" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="departamentName" class="col-sm-2 col-form-label ps-0 pe-1">Oddział firmy</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="departamentName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="formOfPaymentName" class="col-sm-2 col-form-label ps-0 pe-1">Sposób płatności</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="formOfPaymentName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="termOfPayment" class="col-sm-2 col-form-label ps-0 pe-1">Termin płatności</label>
                                                    <div class="col-sm-10 ps-3">
                                                        <input type="text" id="termOfPayment" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>


                                            </div> <!-- end of first column -->


                                            <div class="col-sm-4 mt-2">


                                                <div class="row mb-1">
                                                    <label for="billingFrequencyName" class="col-sm-6 col-form-label">Harmonogram rozliczeń</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="billingFrequencyName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="agreementTypeName" class="col-sm-6 col-form-label">Typ umowy</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="agreementTypeName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="agreementKindName" class="col-sm-6 col-form-label">Forma wydruku</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="agreementKindName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="agreementStatusName" class="col-sm-6 col-form-label">Status umowy</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="agreementStatusName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="billingTypeName" class="col-sm-6 col-form-label">Sposób fakturowania</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="billingTypeName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="vatDirectionName" class="col-sm-6 col-form-label">Kierunek VAT</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="vatDirectionName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="agreementCurrencyName" class="col-sm-6 col-form-label">Waluta umowy</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="agreementCurrencyName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="billingCurrencyName" class="col-sm-6 col-form-label">Waluta fakturowania</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="billingCurrencyName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="invoiceSeriesName" class="col-sm-6 col-form-label">Seria FS</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="invoiceSeriesName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="printoutName" class="col-sm-6 col-form-label">Wydruk FS</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="printoutName" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="isValorization" class="col-sm-6 col-form-label">Waloryzacja</label>
                                                    <div class="col-sm-6">
                                                        <input class="" type="checkbox" id="isValorization"/>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <label for="nextValorizationDate" class="col-sm-6 col-form-label">Data następnej waloryzacji</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" id="nextValorizationDate" class="form-control form-control-sm" disabled/>
                                                    </div>
                                                </div>


                                            </div> <!-- end of second column -->


                                        </div>

                                    </div> <!-- end header -->

                                    <div class="tab-pane fade" id="parameters">

                                        <div class="row mt-2">
                                            <fieldset class="border rounded-2 p-3">
                                                <legend class="float-none w-auto px-3 fs-6">Stawki</legend>

                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-sm table-hover" id="agreementRatesTable">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">Lp</th>
                                                                <th scope="col">Kod usługi</th>
                                                                <th scope="col">Cena netto</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>

                                            </fieldset>
                                        </div>

                                        <div class="row mt-2">
                                            <fieldset class="border rounded-2 p-0">
                                                <legend class="float-none w-auto px-3 fs-6">Ogólne</legend>

                                                <div class="row">
                                                    <div class="col-sm-5">

                                                        <div class="row mb-1">
                                                            <label for="ServiceCompanyUnit" class="col-sm-6 col-form-label">Oddział obsługujący urządzenia</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="ServiceCompanyUnit" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="DKSPerson" class="col-sm-6 col-form-label">Osoba odpowiedzialna DKS</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="DKSPerson" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="DKSTechPerson" class="col-sm-6 col-form-label">Technik</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="DKSTechPerson" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="col-sm-7">

                                                        <div class="row mb-1">
                                                            <label for="InstallationAddress" class="col-sm-4 col-form-label">Adres instalacji urządzeń</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="InstallationAddress" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="ClientPerson" class="col-sm-4 col-form-label">Osoba odp. po stronie klienta</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="ClientPerson" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="ClientPersonToner" class="col-sm-4 col-form-label">Osoba odp. za odbiór tonerów</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" id="ClientPersonToner" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="row mt-2">
                                            <fieldset class="border rounded-2 p-0">
                                                <legend class="float-none w-auto px-3 fs-6">Serwisowe</legend>

                                                <div class="row">

                                                    <div class="col-sm-6">

                                                        <div class="row mb-1">
                                                            <label for="dipStatus" class="col-sm-6 col-form-label">Status instalacji</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="dipStatus" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="CountersCheckType" class="col-sm-6 col-form-label">Sposób odczytu liczników</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="CountersCheckType" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-sm-6">

                                                        <div class="row mb-1">
                                                            <label for="TestCopyAmount" class="col-sm-6 col-form-label">Kopie testowe</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="TestCopyAmount" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="BillingIfNoCounter" class="col-sm-6 col-form-label">Fakturowanie gdy brak licznika</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="BillingIfNoCounter" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                            </fieldset>
                                        </div>

                                        <div class="row mt-2">
                                            <fieldset class="border rounded-2 p-0">
                                                <legend class="float-none w-auto px-3 fs-6">SLA</legend>

                                                <div class="row">
                                                    <div class="col-sm-6">

                                                        <div class="row mb-1">
                                                            <label for="ReactionTime" class="col-sm-6 col-form-label">Czas reakcji (roboczogodziny)</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="ReactionTime" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="RepairTime" class="col-sm-6 col-form-label">Czas naprawy</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="RepairTime" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="ReplacementPartsKind" class="col-sm-6 col-form-label">Rodzaj części</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="ReplacementPartsKind" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">

                                                        <div class="row mb-1">
                                                            <label for="ClientWorkTime" class="col-sm-6 col-form-label">Godziny pracy klienta</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="ClientWorkTime" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="ClientActualWorkTime" class="col-sm-6 col-form-label">Faktyczny czas pracy klienta</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="ClientActualWorkTime" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </fieldset>
                                        </div>

                                        <div class="row mt-2">
                                            <fieldset class="border rounded-2 p-0">
                                                <legend class="float-none w-auto px-3 fs-6">Gwarancyjne</legend>

                                                <div class="row">
                                                    <div class="col-sm-6">

                                                        <div class="row mb-1">
                                                            <label for="PrintAmount" class="col-sm-6 col-form-label">Ilość wydruków</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="PrintAmount" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="CopyLimit" class="col-sm-6 col-form-label">Limit kopii gwarancyjnych</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="CopyLimit" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="MonthsInCycle" class="col-sm-6 col-form-label">Ilość miesięcy w cyklu</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="MonthsInCycle" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">

                                                        <div class="row mb-1">
                                                            <label for="GuaranteeDateDKS" class="col-sm-6 col-form-label">Data gwarancji DKS</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="GuaranteeDateDKS" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-1">
                                                            <label for="GuaranteeDateProducent" class="col-sm-6 col-form-label">Data gwarancji producenta</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="GuaranteeDateProducent" class="form-control form-control-sm" disabled/>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </fieldset>
                                        </div>

                                    </div> <!-- end parameters -->

                                    <div class="tab-pane fade" id="devices">

                                        <div class="table-responsive mt-2">
                                            <table class="table table-striped table-sm table-hover" id="agreementDevicesTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Nazwa</th>
                                                    <th scope="col">Numer urządzenia</th>
                                                    <th scope="col">Numer seryjny</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>


                                    </div> <!-- end devices -->

                                    <div class="tab-pane fade" id="attachments">
                                    </div> <!-- end attachments -->

                                    <div class="tab-pane fade" id="invoices">

                                        <div class="table-responsive mt-2">
                                            <table class="table table-striped table-sm table-hover" id="agreementInvoicesTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Od</th>
                                                    <th scope="col">Do</th>
                                                    <th scope="col">Numer FS</th>
                                                    <th scope="col">Wartość</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>

                                    </div> <!-- end invoices -->

                                    <div class="tab-pane fade" id="history">

                                        <div class="table-responsive mt-2">
                                            <table class="table table-striped table-sm table-hover" id="agreementHistoryTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Typ obiektu</th>
                                                    <th scope="col">Typ zmian</th>
                                                    <th scope="col">Dane dodatkowe</th>
                                                    <th scope="col">Operator</th>
                                                    <th scope="col">Data</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>

                                    </div> <!-- end history -->


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

</div> <!-- end Modal umowa serwisowa -->


{{--

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

--}}


{{--
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
--}}

