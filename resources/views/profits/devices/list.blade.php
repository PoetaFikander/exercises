@extends('profits.index')

@section('profitcontent')

    <div class="container" id="deviceListProfit">

        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12" id="deviceListFilters">

                                <div class="d-inline-block">
                                    <h5>Urządzenia</h5>
                                </div>
                                <div class="d-inline-block ms-5 col-6">
                                    <div class="input-group" id="pdl_form_filter">
                                        <label class="input-group-text" for="for_filter">Filtr</label>
                                        <select class="form-select deviceFilterSelect" id="for_filter" name="type_filter">
                                            <option value="dev_name">Nazwa urządzenia</option>
                                            <option value="dev_serial_no" selected>Nr seryjny</option>
                                            <option value="customer_name">Kontrahent nazwa</option>
                                            <option value="customer_tin">Kontrahent NIP</option>
                                            <option value="agreement_no">Nr umowy</option>
                                        </select>
                                        {{--WJD00996 22E16582--}}
                                        <input type="text" class="form-control" name="text_filter" value="WJD00996">
                                        <button type="button" class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                                    </div>
                                </div>
                                <div class="d-inline-block ms-4">
                                    <div class="form-check fs-5">
                                        <input class="form-check-input" type="checkbox" value="" id="activeDevice" checked>
                                        <label class="form-check-label" for="activeDevice">
                                            Tylko aktywne urządzenia
                                        </label>
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

                            <table class="table table-striped table-sm table-hover" id="devicesListTable">
                                <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Nazwa</th>
                                    <th scope="col">Nr seryjny</th>
                                    <th scope="col">Kontrahent</th>
                                    <th scope="col" class="text-nowrap">NIP</th>
                                    <th scope="col" class="text-nowrap">Umowa</th>
                                    <th scope="col" class="text-nowrap">Status umowy</th>
                                    <th scope="col" class="text-nowrap"><i class="bi bi-currency-dollar"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($devices as $device)
                                    <tr>
                                        <td>{{ $device->dev_id }}</td>
                                        <td class="text-nowrap">{{ $device->dev_name }}</td>
                                        <td class="text-nowrap">{{ $device->dev_serial_no }}</td>
                                        <td class="ellipis">{{ $device->customer_name }}</td>
                                        <td>{{ $device->customer_tin }}</td>
                                        <td>{{ $device->agreement_no }}</td>
                                        <td>{{ $device->agreement_status }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm fw-bold" data-agrid="{{ $device->agreement_id }}" data-devid="{{ $device->dev_id }}"><i class="bi bi-search"></i></button>
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

