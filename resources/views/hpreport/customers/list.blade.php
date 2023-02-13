@extends('hpreport.index')

@section('hprcontent')

    <!-- Modal -->
    <div class="modal fade modal-lg" id="addCustomerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dodaj kontrahenta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-2 row">
                        <label class="col-sm-1 col-form-label text-end" for="customerName">Nazwa</label>
                        <div class="col-sm-11">
                            <div class="input-group">
                                <input type="text" class="form-control border-secondary" id="customerName" name="customerName">
                                <button class="btn btn-outline-secondary" type="button" data-toggle="h_c_l_modalcustomerbtn">
                                    <i class="bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label class="col-sm-1 col-form-label text-end" for="customerTin">NIP</label>
                        <div class="col-sm-11">
                            <div class="input-group">
                                <input type="text" class="form-control border-secondary" id="customerTin" name="customerName">
                                <button class="btn btn-outline-secondary" type="button" data-toggle="h_c_l_modalcustomerbtn">
                                    <i class="bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 row">

                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover my-table">

                                <thead>
                                <tr>
                                    <th scope="col">Kod</th>
                                    <th scope="col">Nazwa</th>
                                    <th scope="col">NIP</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>

                                <tbody data-toggle="h_c_l_modalcustomertbody">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>

                            </table>
                        </div>

                    </div>
                    <div class="mb-2 row" data-toggle="h_c_l_modalcustomeraddmessage"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zakończ</button>
                    {{--<button type="button" class="btn btn-primary">Zapisz</button>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="row">

            <div class="col-md-12 py-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Kontrahenci posiadający kontrakty
                            <a href="" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addCustomerModal">Dodaj
                                kontrahenta</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-hover my-table">

                                <thead>
                                <tr>
                                    <th scope="col">Kod</th>
                                    <th scope="col">Nazwa</th>
                                    <th scope="col">NIP</th>
                                    <th scope="col">Akcje</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td class="text-nowrap">{{ $customer->code }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->tin }}</td>
                                        <td class="text-nowrap">
                                            <a href="#"><button class="btn btn-sm"><i class="bi-search"></i></button></a>
                                            <button
                                                class="btn btn-sm"
                                                data-toggle="customerdelete"
                                                data-id="{{ $customer->altum_id }}"
                                                data-name="{{ $customer->name }}"
                                            ><i class="bi-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection


