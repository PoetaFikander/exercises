@extends('profits.index')

@section('profitcontent')

    <div class="container" id="customerListProfit">

        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12" id="customerListFilters">

                                <div class="d-inline-block">
                                    <h5>Kontrahent</h5>
                                </div>
                                <div class="d-inline-block ms-5 col-7">
                                    <div class="input-group" id="pcl_form_filter">
                                        <label class="input-group-text" for="filter">Filtr</label>
                                        <div class="col-2">
                                        <select class="form-select customerFilterSelect" id="filter">
                                            <option value="customer_name">Nazwa kontrahenta</option>
                                            <option value="customer_tin">NIP kontrahenta</option>
                                            <option value="agr_no" selected>Nr umowy</option>
                                            <option value="dev_name">Nazwa urządzenia</option>
                                            <option value="dev_serial_no">Nr ser. urządzenia</option>
                                            <option value="dev_model">Model urządzenia</option>
                                            <option value="dev_family">Rodzina urządzenia</option>
                                        </select>
                                        </div>
                                        <!-- UM/004570/2020 UM/000003/2023 	UM/000143/2022 UM/004480/2020 UM/004025/2020 UM/007447/2020-->
                                        <input type="text" class="form-control" id="customerTxtSearch" value="UM/007447/2020">
                                        <button type="button" class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                                    </div>
                                </div>


                                <div class="d-inline-block ms-5 col-3">
                                    <div class="input-group" id="pcl_form_custType">
                                        <label class="input-group-text" for="customerType">Typ kontrahenta</label>
                                        <select class="form-select deviceFilterSelect" id="customerType">
                                            <option value="1" selected>nabywca</option>
                                            <option value="2">odbiorca</option>
                                        </select>
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-striped table-sm table-hover" id="customersListTable">
                                <thead>
                                <tr>
                                    <th scope="col">Kod</th>
                                    <th scope="col">Nazwa</th>
                                    <th scope="col">NIP</th>
                                    <th scope="col">Kod pocztowy</th>
                                    <th scope="col">Miejscowość</th>
                                    <th scope="col">Adres</th>
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

