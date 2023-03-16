<div class="accordion mt-3 _d-none" id="accordionProfit">

    {{--
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingCustomer">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCustomer"
                    aria-expanded="true" aria-controls="collapseCustomer">
                <span class="fs-5">Kontrahenci</span>
            </button>
        </h2>
        <div id="collapseCustomer" class="accordion-collapse collapse" aria-labelledby="headingCustomer"
             data-bs-parent="#accordionProfit">
            <div class="accordion-body">

                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover" id="customerTable">
                        <thead>
                        <tr>
                            <th scope="col" class="text-nowrap">Nazwa</th>
                            <th scope="col">NIP</th>
                            <th scope="col">Adres</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    --}}

    {{--
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingContract">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContract"
                    aria-expanded="true" aria-controls="collapseContract">
                <span class="fs-5">Umowy</span>
            </button>
        </h2>
        <div id="collapseContract" class="accordion-collapse collapse" aria-labelledby="headingContract"
             data-bs-parent="#accordionProfit">
            <div class="accordion-body">

                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover" id="contractTable">
                        <thead>
                        <tr>
                            <th scope="col" class="text-nowrap">Umowa</th>
                            <th scope="col">Kontrahent</th>
                            <th scope="col">Oddział</th>
                            <th scope="col" class="text-nowrap">Status umowy</th>
                            <th scope="col">Okres od</th>
                            <th scope="col">do</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    --}}

    {{--
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingDevice">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDevice"
                    aria-expanded="true" aria-controls="collapseDevice">
                <span class="fs-5">Urządzenia</span>
            </button>
        </h2>
        <div id="collapseDevice" class="accordion-collapse collapse" aria-labelledby="headingDevice"
             data-bs-parent="#accordionProfit">
            <div class="accordion-body">

                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover" id="deviceTable">
                        <thead>
                        <tr>
                            <th scope="col">Nazwa</th>
                            <th scope="col">Nr seryjny</th>
                            <th scope="col">Kontrahent</th>
                            <th scope="col" class="text-nowrap">NIP</th>
                            <th scope="col" class="text-nowrap">Umowa</th>
                            <th scope="col" class="text-nowrap">Status umowy</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    --}}

    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                <span class="fs-5">Zlecenia</span>
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
             data-bs-parent="#accordionProfit">
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
             data-bs-parent="#accordionProfit">
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
             data-bs-parent="#accordionProfit">
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
             data-bs-parent="#accordionProfit">
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
             data-bs-parent="#accordionProfit">
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
             data-bs-parent="#accordionProfit">
            <div class="accordion-body">

                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover profit-summary" id="FSTable">
                        <thead>
                        <tr>
                            {{--<th scope="col">Id</th>--}}
                            <th scope="col">Numer</th>
                            <th scope="col">Data</th>
                            <th scope="col">Wartość</th>
                            {{--<th scope="col"></th>--}}
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
             data-bs-parent="#accordionProfit">
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
             data-bs-parent="#accordionProfit">
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
             data-bs-parent="#accordionProfit">
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
