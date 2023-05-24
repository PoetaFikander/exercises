<div class="accordion" id="accordionBokContracts">

    <div class="accordion-item" id="BillingIfNoCounterItem"> <!-- item one -->
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                    aria-controls="collapseOne">
                Fakturowanie gdy brak licznika
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionBokContracts">
            <div class="accordion-body">

                <div class="row">
                    <div class="col-md-12">

                        <div class="d-inline-block col-md-3">
                            <div class="input-group" id="BINC-filters"> <!-- BINC = BillingIfNoCounter -->
                                <label class="input-group-text">Nr umowy</label>
                                <!-- UM/003766/2020 UM/004054/2020 -->
                                <input type="text" class="form-control" name="agreementNo" value="UM/003766/2020">
                                <button type="button" class="btn btn-outline-secondary" id="btn-search"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                        <div class="d-inline-block ms-5 col-md-4">
                            <div class="d-inline me-3">
                                <label>Wszystkie urządzenia:</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radioOptions" id="radioYes" value="1">
                                <label class="form-check-label" for="radioYes">tak</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radioOptions" id="radioNo" value="2">
                                <label class="form-check-label" for="radioNo">nie</label>
                            </div>
                        </div>
                        <div class="d-inline-block col-md-1 float-end">
                            <button type="button" class="btn btn-success btn-sm" id="btn-save">Zapisz</button>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="table-responsive">
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

            </div><!-- end accordion-body -->
        </div>
    </div> <!-- end item one -->

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                    aria-controls="collapseTwo">
                Accordion Item #2
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionBokContracts">
            <div class="accordion-body">
                <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes
                that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You
                can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within
                the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                    aria-controls="collapseThree">
                Accordion Item #3
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionBokContracts">
            <div class="accordion-body">
                <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes
                that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You
                can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within
                the <code>.accordion-body</code>, though the transition does limit overflow.
            </div>
        </div>
    </div>
</div>
