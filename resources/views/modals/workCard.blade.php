<div class="modal workCard modal-type-1" tabindex="-1" id="modal-workCard" aria-labelledby="modal-workCard-label" aria-hidden="true">
    <div class="modal-dialog modal-xl">

        <div class="modal-content"><!-- modal-content -->

            <div class="modal-header" id="modal-header-text"><!-- modal-header -->
                <h5 class="modal-title" id="modal-workCard-label">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
            </div><!-- end modal-header -->

            <div class="modal-body"><!-- modal-body -->

                <div class="container-fluid">
                    <div class="row">

                        <div class="col-lg-3" id="wc-tab-0"><!-- parametry nagłówka -->

                            <div class="row">
                                <label class="col-form-label">Status</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="wc_status_name" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Nazwa urządzenia</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="dev_name" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Nr seryjny urządzenia</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="dev_serial_no" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Data rejestracji zgłoszenia</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="service_register_date" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Data ostatniej modyfikacji zlecenia</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="wc_last_modification_date" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Technik</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="wc_service_person_name" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Rodzaj usterki</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="wc_fault_type_name" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Priorytet</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="wc_priority_name" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Forma rozliczenia</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="wc_type_name" disabled/>
                            </div>

                            <div class="row">
                                <label class="col-form-label">Planowana data realizacji</label>
                            </div>
                            <div class="row mb-2">
                                <input type="text" class="form-control form-control-sm" name="wc_planned_realization_term" disabled/>
                            </div>

                        </div><!-- end parametry nagłówka -->

                        <div class="col-lg-9" id="tabs"><!-- tabs zakładki -->

                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a href="#wc-tab-1" class="nav-link active" data-bs-toggle="tab">Opisy</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#wc-tab-2" class="nav-link" data-bs-toggle="tab">Parametry</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#wc-tab-3" class="nav-link" data-bs-toggle="tab">Rejestr czynności</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#wc-tab-4" class="nav-link" data-bs-toggle="tab">Materiały</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#wc-tab-5" class="nav-link" data-bs-toggle="tab">Usługi</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#wc-tab-6" class="nav-link" data-bs-toggle="tab">Dokumenty</a>
                                </li>
                            </ul>

                            <div class="tab-content mx-3 mt-2">

                                <div class="tab-pane fade show active" id="wc-tab-1">
                                    <div>
                                        <fieldset class="border rounded-2 border-1">
                                            <legend class="float-none w-auto px-3 fs-6 mb-0">Opis usterki</legend>
                                            <div class="row">
                                                <textarea class="form-control form-control-sm" name="wc_fault_description" rows="16" disabled></textarea>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="mt-2">
                                        <fieldset class="border rounded-2 border-1">
                                            <legend class="float-none w-auto px-3 fs-6 mb-0">Dodatkowe ustalenia z umowy</legend>
                                            <div class="row">
                                                <textarea class="form-control form-control-sm" name="agr_description" rows="8" disabled></textarea>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div><!-- end tab-1 -->

                                <div class="tab-pane fade" id="wc-tab-2">
                                    <div class="row">

                                        <fieldset class="border rounded-2 border-1">
                                            <legend class="float-none w-auto px-3 fs-6">Naprawa</legend>
                                            <div class="row">

                                                <div class="col-sm-6"><!-- lewa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Czy urządzenie działało?</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_was_device_working"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Dojazd (km)</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_driving_distance"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Ilość kopii testowych</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_test_copies_amount"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                </div><!-- end lewa kolumna -->

                                                <div class="col-sm-6"><!-- prawa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Czy urządzenie działa?</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_is_device_working"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Czas całkowity</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_total_time"
                                                                   disabled/>
                                                        </div>
                                                    </div>


                                                </div><!-- end prawa kolumna -->

                                            </div>
                                        </fieldset>

                                        <fieldset class="border rounded-2 border-1 mt-2">
                                            <legend class="float-none w-auto px-3 fs-6">SLA</legend>
                                            <div class="row">

                                                <div class="col-sm-6"><!-- lewa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Sposób odczytu liczników</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_counter_reading_type_name"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Części zamienne</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="agr_replacement_parts_name"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Godziny pracy klienta</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_client_work_time"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Faktyczny czas pracy klienta</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_client_actual_work_time"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                </div><!-- end lewa kolumna -->

                                                <div class="col-sm-6"><!-- prawa kolumna -->

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Gwarancja producenta</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_warranty_producer"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Gwarancja DKS</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_warranty_dks"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Zadeklarowany czas reakcji</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_reaction_time"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="mx-1">
                                                        <div class="row">
                                                            <label class="col-form-label">Zadeklarowany czas naprawy</label>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <input type="text" class="form-control form-control-sm" name="wc_repair_time"
                                                                   disabled/>
                                                        </div>
                                                    </div>

                                                </div><!-- end prawa kolumna -->

                                            </div>
                                        </fieldset>

                                    </div>
                                </div><!-- end tab-2 -->

                                <div class="tab-pane fade" id="wc-tab-3">

                                    <div class="row">
                                        <div class="table-responsive mt-3 pt-1">
                                            <table class="table table-striped table-sm table-hover" id="actionTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Czynność</th>
                                                    <th scope="col">Data rozpoczęcia</th>
                                                    <th scope="col">Data zakończenia</th>
                                                    <th scope="col">Opis/Dane dodatkowe</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div><!-- end tab-3 -->

                                <div class="tab-pane fade" id="wc-tab-4">

                                    <div class="row">
                                        <div class="table-responsive mt-3 pt-1">
                                            <table class="table table-striped table-sm table-hover" id="materialTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Kod</th>
                                                    <th scope="col">Nazwa</th>
                                                    <th scope="col">Zamówino</th>
                                                    <th scope="col">Zrealizowano</th>
                                                    <th scope="col">Zużyto</th>
                                                    <th scope="col">Cena</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div><!-- end tab-4 -->

                                <div class="tab-pane fade" id="wc-tab-5">

                                    <div class="row">
                                        <div class="table-responsive mt-3 pt-1">
                                            <table class="table table-striped table-sm table-hover" id="servicelTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Kod</th>
                                                    <th scope="col">Nazwa</th>
                                                    <th scope="col">Ilość</th>
                                                    <th scope="col">Cena</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div><!-- end tab-5 -->

                                <div class="tab-pane fade" id="wc-tab-6">

                                    <div class="row">
                                        <div class="table-responsive mt-3 pt-1">
                                            <table class="table table-striped table-sm table-hover" id="docTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Numer</th>
                                                    <th scope="col">Data</th>
                                                    <th scope="col">Kontrahent</th>
                                                    <th scope="col">Wartość netto</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div><!-- end tab-6 -->

                            </div>


                        </div><!-- end tabs zakładki -->

                    </div>
                </div>

            </div><!-- end modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
            </div>

        </div><!-- end modal-content -->
    </div>
</div>
