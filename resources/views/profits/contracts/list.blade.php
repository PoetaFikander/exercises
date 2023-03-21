@extends('profits.index')

@section('profitcontent')

    <div class="container" id="contractListProfit">

        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12" id="contractListFilters">

                                <div class="d-inline-block">
                                    <h5>Umowa</h5>
                                </div>
                                <div class="d-inline-block ms-5 col-6">
                                    <div class="input-group" id="pcl_form_filter">
                                        <label class="input-group-text" for="filter">Filtr</label>
                                        <select class="form-select deviceFilterSelect" id="filter">
                                            <option value="agr_no" selected>Nr umowy</option>
                                            <option value="customer_name">Nazwa kontrahenta</option>
                                            <option value="customer_tin">NIP kontrahenta</option>
                                            <option value="dev_name">Nazwa urządzenia</option>
                                            <option value="dev_serial_no">Nr ser. urządzenia</option>
                                            <option value="dev_model">Model urządzenia</option>
                                            <option value="dev_family">Rodzina urządzenia</option>
                                        </select>
                                        <!-- UM/004570/2020 UM/000003/2023 	UM/000143/2022 UM/004480/2020-->
                                        <input type="text" class="form-control" id="contractTxtSearch" value="UM/004054/2020">
                                        <button type="button" class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                                    </div>
                                </div>

                                <div class="d-inline-block ms-5 col-2">
                                    <div class="input-group" id="pcl_form_departments">
                                        <label class="input-group-text" for="departments">Oddział</label>
                                        <select class="form-select deviceFilterSelect" id="departments" name="for_departments">
                                            <option value="0" selected>Wszystkie</option>
                                            @foreach($departments as $d)
                                                <option value="{{ $d->altum_id }}">{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="d-inline-block ms-4">
                                    <div class="form-check fs-5">
                                        <input class="form-check-input" type="checkbox" value="" id="activeAgreement" checked>
                                        <label class="form-check-label" for="activeAgreement">
                                            Tylko aktywne umowy
                                        </label>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-striped table-sm table-hover" id="contractsListTable">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-nowrap">Umowa</th>
                                    <th scope="col">Kontrahent</th>
                                    <th scope="col">Oddział</th>
                                    <th scope="col" class="text-nowrap">Status umowy</th>
                                    <th scope="col">Okres od</th>
                                    <th scope="col">do</th>
                                    <th scope="col" class="text-nowrap"><i class="bi bi-currency-dollar"></i></th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

