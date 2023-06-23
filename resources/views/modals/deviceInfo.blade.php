<div class="modal device-info modal-type-1" tabindex="-1" id="modal-deviceInfo" aria-labelledby="modal-deviceInfo-label" aria-hidden="true">
    <div class="modal-dialog modal-xl">

        <div class="modal-content">

            <div class="modal-header" id="modal-header-text">
                <h3 class="modal-title" id="modal-deviceInfo-label">Urządzenie</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="container-fluid">
                    <div class="row">

                        <div class="col-lg-4" id="di-tab-0"><!-- parametry nagłówka -->

                            <div class="row d-inline ms-3" title="model">
                                Typ:<strong><span title="dev_type_name"></span></strong>
                                Rodzaj:<strong><span title="dev_kind_name"></span></strong>
                                Format:<strong><span title="dev_format_name"></span></strong>
                            </div>

                            <div class="row mt-3">
                                <label class="col-form-label">Nr umowy</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="agr_no" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Nabywca</label>
                            </div>
                            <div class="row mb-2">
                                <textarea class="form-control form-control-sm" name="agr_cust_name" rows="2" disabled></textarea>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Data wprowadzenia umowy</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="agr_date_of_issue" disabled/>
                            </div>
                            <div class="row">
                                <label class="col-form-label">Data rozpoczęcia umowy</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="agr_date_of_start" disabled/>
                            </div>
                            <div class="row">
                                <label class="col-form-label">Data zakończenia umowy</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="agr_date_of_end" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Oddział obsługujący</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="dev_service_company_unit_name" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Adres instalacji</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="dev_installation_address" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Adres instalacji uzupełnienie</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="dev_installation_address_add_data" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Adres wysyłki</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="dev_toner_address" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Adres wysyłki uzupełnienie</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="dev_toner_address_add_data" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Odliczaj wartość odczytów od ryczałtu</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="dev_extra_value_in_cnu_name" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Usługa dla odczytów ponad ryczałt</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="dev_extra_value_service_name" disabled/>
                            </div>


                        </div><!-- end parametry nagłówka -->

                        <div class="col-lg-8" id="tabs"><!-- tabs zakładki -->

                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a href="#di-tab-1" class="nav-link active" data-bs-toggle="tab">Info</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#di-tab-2" class="nav-link" data-bs-toggle="tab">Parametry</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#di-tab-3" class="nav-link" data-bs-toggle="tab">Stawki usług</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#di-tab-4" class="nav-link" data-bs-toggle="tab">Liczniki</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#di-tab-5" class="nav-link" data-bs-toggle="tab">Zlecenia</a>
                                </li>
                            </ul>

                            <div class="tab-content mx-3 mt-2">

                                <div class="tab-pane fade show active" id="di-tab-1">
                                    <div class="row">

                                        <fieldset class="border rounded-2 border-1">

                                            <legend class="float-none w-auto px-3 fs-6">Przegląd</legend>

                                            <div class="row">

                                                <div class="col-sm-6"><!-- lewa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Data gwarancji</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_guarantee_date_dks"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Ostatni przegląd</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_last_review_date"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Ilość dni od ostatniego przeglądu</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_days_at_last_review"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                </div><!-- end lewa kolumna -->

                                                <div class="col-sm-6"><!-- prawa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Gwarancja aktywna</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_is_under_warranty"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Następny przegląd</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_next_review_date"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Aktywne zlecenie na przegląd</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_active_review_wc_no"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                </div><!-- end prawa kolumna -->

                                            </div>

                                        </fieldset>

                                        <fieldset class="border rounded-2 border-1 mt-2">

                                            <legend class="float-none w-auto px-3 fs-6 mb-0">Kontakty</legend>

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover mt-0" id="contactTable">
                                                    <thead>
                                                    <tr>
                                                        <th class="fw-normal" scope="col">Typ</th>
                                                        <th class="fw-normal" scope="col">Numer</th>
                                                        <th class="fw-normal" scope="col">Uwagi</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>

                                        </fieldset>

                                        <div class="mt-2">
                                            <fieldset class="border rounded-2 border-1">
                                                <legend class="float-none w-auto px-3 fs-6 mb-0">Dodatkowe ustalenia z klientem</legend>
                                                <div class="row">
                                                    <textarea class="form-control form-control-sm" name="dev_description" rows="8" disabled></textarea>
                                                </div>
                                            </fieldset>
                                        </div>

                                    </div>
                                </div><!-- end tab-1 -->

                                <div class="tab-pane fade" id="di-tab-2">
                                    <div class="row">

                                        <fieldset class="border rounded-2 border-1">
                                            <legend class="float-none w-auto px-3 fs-6">Parametry serwisowe</legend>

                                            <div class="row">

                                                <div class="col-sm-6"><!-- lewa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Status instalacji</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_installation_status_name"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Sposób odczytu liczników</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_counters_check_type_name"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                </div><!-- end lewa kolumna -->

                                                <div class="col-sm-6"><!-- prawa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Kopie testowe</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_test_copy_amount"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Fakturowanie gdy brak licznika</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_billing_if_no_counter_name"
                                                                   disabled/>
                                                        </div>
                                                    </div>


                                                </div><!-- end prawa kolumna -->

                                            </div>

                                        </fieldset>

                                        <fieldset class="border rounded-2 border-1 mt-2">

                                            <legend class="float-none w-auto px-3 fs-6">Parametry SLA</legend>

                                            <div class="row">

                                                <div class="col-sm-6"><!-- lewa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Czas reakcji (ilość godzin)</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_reaction_time"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Godziny pracy klienta</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_client_work_time"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Rodzaj części zamiennych</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_replacement_parts_kind_name"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                </div><!-- end lewa kolumna -->

                                                <div class="col-sm-6"><!-- prawa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Czas naprawy (ilość godzin)</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_repair_time"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Faktyczny czas pracy klienta</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_client_actual_work_time"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Obrót urządzenia (najem)</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_device_income"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                </div><!-- end prawa kolumna -->

                                            </div>

                                        </fieldset>

                                        <fieldset class="border rounded-2 border-1 mt-2">

                                            <legend class="float-none w-auto px-3 fs-6">Parametry gwarancji</legend>

                                            <div class="row">

                                                <div class="col-sm-6"><!-- lewa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Data gwarancji DKS</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_guarantee_date_dks"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Ilość wydruków</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_print_amount"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Limit kopii gwarancyjnych</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_copy_limit"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                </div><!-- end lewa kolumna -->

                                                <div class="col-sm-6"><!-- prawa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Data gwarancji producenta</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_guarantee_date_producent"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Ilość miesiecy w cyklu</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_months_in_cycle"
                                                                   disabled/>
                                                        </div>
                                                    </div>


                                                </div><!-- end prawa kolumna -->

                                            </div>

                                        </fieldset>

                                        <fieldset class="border rounded-2 border-1 mt-2">

                                            <legend class="float-none w-auto px-3 fs-6">Osoby odpowiedzialne</legend>

                                            <div class="row">

                                                <div class="col-sm-6"><!-- lewa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Osoba odpowiedzialna DKS</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_dks_person"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Technik</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_dks_tech_person"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                </div><!-- end lewa kolumna -->

                                                <div class="col-sm-6"><!-- prawa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Osoba odpowiedzialna Klient</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_client_person"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Osoba odpowiedzialna za odbiór</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="dev_client_person_pickup"
                                                                   disabled/>
                                                        </div>
                                                    </div>


                                                </div><!-- end prawa kolumna -->

                                            </div>

                                        </fieldset>

                                    </div>
                                </div><!-- end tab-2 -->

                                <div class="tab-pane fade" id="di-tab-3">

                                    <div class="row">
                                        <div class="table-responsive mt-3 pt-1">
                                            <table class="table table-striped table-sm table-hover" id="rateTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Lp</th>
                                                    <th scope="col">Kod usługi</th>
                                                    <th scope="col">Cena</th>
                                                    <th scope="col">Liczba kopii w CNU</th>
                                                    <th scope="col">Odliczaj liczniki</th>
                                                    <th scope="col">Centrum</th>
                                                    <th scope="col">Dane dodatkowe</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div><!-- end tab-3 -->

                                <div class="tab-pane fade" id="di-tab-4">

                                    <div class="row">
                                        <div class="table-responsive mt-3 pt-1">
                                            <table class="table table-striped table-sm table-hover" id="counterTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Kod</th>
                                                    <th scope="col">Wartość</th>
                                                    <th scope="col">Data odczytu</th>
                                                    <th scope="col">Źródło</th>
                                                    <th scope="col">Umowa</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div><!-- end tab-4 -->

                                <div class="tab-pane fade" id="di-tab-5">

                                    <div class="row">
                                        <div class="table-responsive mt-3 pt-1">
                                            <table class="table table-striped table-sm table-hover" id="workCardTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Nr zlecenia</th>
                                                    <th scope="col">Technik</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Data otwarcia</th>
                                                    <th scope="col">Data zamknięcia</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div><!-- end tab-5 -->

                            </div><!-- end tab-content -->

                        </div><!-- end tabs -->

                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
            </div>
        </div>
    </div>
</div>


