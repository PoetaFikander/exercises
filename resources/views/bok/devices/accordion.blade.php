<div class="accordion" id="accordionBokDevices">

    <div class="accordion-item" id="deviceModelChangeItem"> <!-- item one -->
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                    aria-controls="collapseOne">
                Model
            </button>
        </h2>

        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionBokDevices">
            <div class="accordion-body">

                <div class="row">
                    <div id="DMC-filters">

                        <div class="col-md-12">

                            <div class="d-inline-block col-md-3">
                                <div class="input-group"> <!-- DMC = deviceModelChange -->
                                    <label class="input-group-text">Nr seryjny</label>
                                    <input type="text" class="form-control" name="serialNo" value="A4FK021012176">
                                    <button type="button" class="btn btn-outline-secondary" id="btn-search"><i class="bi bi-search"></i></button>
                                </div>
                            </div>

                            <div class="d-inline-block col-md-3 ms-2">
                                <div class="input-group">
                                    <label class="input-group-text">Nazwa</label>
                                    <input type="text" class="form-control" name="devName" data-serialno="" data-itemid="0" value="" disabled>
                                </div>
                            </div>

                            <div class="d-inline-block col-md-4 ms-2">
                                <div class="input-group">
                                    <label class="input-group-text">Nowy model</label>
                                    <select class="form-select" name="model">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($models as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-inline-block col-md-1 float-end">
                                <button type="button" class="btn btn-success btn-sm" id="btn-save">Zapisz</button>
                            </div>

                        </div>

                        <div class="col-md-12 mt-2">

                            <div class="d-inline-block col-md-7">
                                <div class="input-group">

                                    <label class="input-group-text">Producent</label>
                                    <select class="form-select" name="producer">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($deviceProducers as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>

                                    <label class="input-group-text">Typ</label>
                                    <select class="form-select" name="type">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($deviceTypes as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>

                                    <label class="input-group-text">Rodzaj</label>
                                    <select class="form-select" name="kind">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($deviceKinds as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="btn btn-outline-secondary" id="btn-search-model"><i class="bi bi-search"></i></button>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div><!-- end accordion-body -->
        </div>
    </div> <!-- end item one -->


    <div class="accordion-item" id="ReplacementPartsKindItem"> <!-- item two -->
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                    aria-controls="collapseTwo">
                Rodzaj części zamiennych
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionBokDevices">
            <div class="accordion-body">

                <div id="RPK-filters">

                    <div class="row">


                        <div class="d-inline-block col-md-12">
                            <div class="input-group">

                                <label class="input-group-text">Oddział</label>
                                <select class="form-select" name="department">
                                    @foreach($departments as $d)
                                        <option value="{{ $d->altum_id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>

                                <label class="input-group-text">Model</label>
                                <select class="form-select" name="model" style="min-width: 300px">
                                    <option value="0">--- Nie wybrano ---</option>
                                    @foreach($models as $part)
                                        <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                    @endforeach
                                </select>

                                <label class="input-group-text">Rodzaj urządzenia</label>
                                <select class="form-select" name="kind">
                                    <option value="0">--- Nie wybrano ---</option>
                                    @foreach($deviceKinds as $part)
                                        <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                    @endforeach
                                </select>

                                <label class="input-group-text">Kod pocztowy</label>
                                <input type="text" class="form-control" name="zipcode" value="">

                                <button type="button" class="btn btn-outline-secondary" id="btn-get-dev"><i class="bi bi-search"></i>
                                </button>


                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-2">

                            <div class="d-inline-block col-md-4">
                                <div class="input-group">
                                    <label class="input-group-text">Rodzaj części zamiennych</label>
                                    <select class="form-select filter-select-w" name="partsKind">
                                        <!-- deviceReplacementParts -->
                                        @foreach($deviceReplacementParts as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-outline-secondary" id="btn-check"><i class="bi bi-chevron-double-right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-inline-block col-md-1 ms-3 float-end_">
                                <button type="button" class="btn btn-success btn-sm_" id="btn-save">Zapisz</button>
                            </div>

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
                                <th scope="col">Technik</th>
                                <th scope="col">Adres</th>
                                <th scope="col">RCZ</th>
                                <th scope="col">nowy RCZ</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div><!-- end accordion-body -->
        </div>
    </div> <!-- end item two -->


    <div class="accordion-item" id="exchangeTechnicianByTechnicianItem"> <!-- item three -->
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                    aria-controls="collapseThree">
                Technik przypisany do urządzenia (technik->technik)
            </button>
        </h2>

        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionBokDevices">
            <div class="accordion-body">

                <div id="ETBT-filters">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="d-inline-block col-md-4">
                                <div class="input-group">

                                    <label class="input-group-text">Aktualny technik</label>
                                    <select class="form-select" name="technician-old">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($technicians as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>

                                    <button type="button" class="btn btn-outline-secondary" id="btn-check"><i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-2">

                            <div class="d-inline-block col-md-4">
                                <div class="input-group">
                                    <label class="input-group-text">Nowy technik&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <select class="form-select" name="technician-new">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($technicians as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-inline-block col-md-1 ms-3 float-end_">
                                <button type="button" class="btn btn-success btn-sm_" id="btn-save">Zapisz</button>
                            </div>

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
                                <th scope="col">Umowa</th>
                                <th scope="col">Adres</th>
                                <th scope="col">Kontrahent</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div><!-- end accordion-body -->
        </div>
    </div><!-- end item three -->


    <div class="accordion-item" id="changeDeviceTechnicianItem"> <!-- item four -->
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                    aria-controls="collapseFour">
                Technik przypisany do urządzenia
            </button>
        </h2>

        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionBokDevices">

            <div class="accordion-body">

                <div id="CDTI-filters">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="d-inline-block col-md-11">
                                <div class="input-group">

                                    <label class="input-group-text">Oddział</label>
                                    <select class="form-select" name="department">
                                        @foreach($departments as $d)
                                            <option value="{{ $d->altum_id }}">{{ $d->name }}</option>
                                        @endforeach
                                    </select>

                                    <label class="input-group-text">Technik</label>
                                    <select class="form-select" name="technician-old">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($technicians as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>

                                    <label class="input-group-text">Rodzaj urządzenia</label>
                                    <select class="form-select" name="dewKind">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($deviceKinds as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>

                                    <label class="input-group-text">Kod pocztowy</label>
                                    <input type="text" class="form-control" name="zipcode" value="">

                                    <button type="button" class="btn btn-outline-secondary" id="btn-check"><i class="bi bi-search"></i>
                                    </button>

                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 mt-2">

                            <div class="d-inline-block col-md-4">
                                <div class="input-group">
                                    <label class="input-group-text">Nowy technik</label>
                                    <select class="form-select" name="technician-new">
                                        <option value="0">--- Nie wybrano ---</option>
                                        @foreach($technicians as $part)
                                            <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-inline-block col-md-1 ms-3 float-end_">
                                <button type="button" class="btn btn-success btn-sm_" id="btn-save">Zapisz</button>
                            </div>

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
                                <th scope="col">Umowa</th>
                                <th scope="col">Adres</th>
                                <th scope="col">Kontrahent</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div><!-- end accordion-body -->
        </div>
    </div><!-- end item four -->


    <div class="accordion-item" id="noInstallationAddressItem"> <!-- item five -->
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true"
                    aria-controls="collapseFive">
                Brak adresu instalacji
            </button>
        </h2>

        <div id="collapseFive" class="accordion-collapse collapse show" data-bs-parent="#accordionBokDevices">

            <div class="accordion-body">

                <div class="row">
                    <div class="d-inline-block col-md-8">
                        <div class="input-group">

                            <label class="input-group-text">Oddział</label>
                            <select class="form-select" name="department">
                                <option value="0">--- Nie wybrano ---</option>
                                @foreach($departments as $d)
                                    <option value="{{ $d->altum_id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>

                            <label class="input-group-text">Rodzaj umowy</label>
                            <select class="form-select" name="agrKind">
                                <option value="0">--- Nie wybrano ---</option>
                                <option value="1">umowa UM</option>
                                <option value="2">umowa UI</option>
                            </select>

                            <label class="input-group-text">Problem</label>
                            <select class="form-select" name="problem">
                                <option value="0">--- Nie wybrano ---</option>
                                <option value="1">adres nieaktywny</option>
                                <option value="2">adres nie wybrany</option>
                            </select>

                            <button type="button" class="btn btn-outline-secondary" id="btn-check"><i class="bi bi-search"></i>
                            </button>

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
                                <th scope="col">Umowa</th>
                                {{--<th scope="col">Technik</th>--}}
                                <th scope="col">Kontrahent</th>
                                <th scope="col">Adres</th>
                                <th scope="col">Adres status</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div><!-- end accordion-body -->
        </div>
    </div><!-- end item five -->


</div>
