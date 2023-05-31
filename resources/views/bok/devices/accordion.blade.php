<div class="accordion" id="accordionBokDevices">

    <div class="accordion-item" id="deviceModelChangeItem"> <!-- item one -->
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                    aria-controls="collapseOne">
                Zmiana modelu
            </button>
        </h2>

        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionBokDevices">
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
                                        @foreach($deviceModels as $part)
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


                        </div>

                        <div class="col-md-12 mt-2">

                            <div class="d-inline-block col-md-7">
                                <div class="input-group">

                                    <label class="input-group-text">Producent</label>
                                    <select class="form-select" name="producer">
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

                {{--
                <div class="row">
                    <div class="table-responsive mt-3 pb-1">
                        <table class="table table-striped table-sm table-hover" id="deviceTable">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Nr seryjny</th>
                                <th scope="col">Status</th>
                                <th scope="col">FGBL</th>
                                <th scope="col">Tak</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                --}}

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

                <div class="row" id="RPK-filters">
                    <div class="col-md-12">

                        <div class="d-inline-block col-md-3">
                            <div class="input-group"> <!-- RPK = ReplacementPartsKind -->
                                <label class="input-group-text">Nr umowy</label>
                                <!-- UM/003766/2020 UM/004054/2020 -->
                                <input type="text" class="form-control" name="agreementNo" value="UM/004054/2020">
                                <button type="button" class="btn btn-outline-secondary" id="btn-search"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <div class="d-inline-block col-md-4 ms-5">
                            <div class="input-group">
                                <label class="input-group-text">Rodzaj części zamiennych</label>
                                <select class="form-select filter-select-w" name="partsKind">
                                    <!-- deviceReplacementParts -->
                                    @foreach($deviceReplacementParts as $part)
                                        <option value="{{$part->dic_field_id}}">{{$part->dic_field_name}}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-secondary" id="btn-check"><i class="bi bi-chevron-double-right"></i></button>
                            </div>
                        </div>
                        <div class="d-inline-block col-md-1 float-end">
                            <button type="button" class="btn btn-success btn-sm" id="btn-save">Zapisz</button>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-sm table-hover" id="deviceTable">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nazwa</th>
                                <th scope="col">Nr seryjny</th>
                                <th scope="col">Status</th>
                                <th scope="col">RCZ</th>
                                <th scope="col">#</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>


            </div><!-- end accordion-body -->
        </div>
    </div> <!-- end item two -->

    {{--
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                    aria-controls="collapseThree">
                Accordion Item #3
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#accordionBokDevices">
            <div class="accordion-body">
                <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes
                that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You
                can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within
                the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
        </div>
    </div>
    --}}

</div>
