@extends('profits.index')

@section('profitcontent')

    <div class="container" id="profit" data-type="3">

        <div class="row">

            <div class="col-md-12 py-2">

                <div class="card">

                    <div class="card-header">

                        <div class="row">

                            <div class="col-md-11">

                                <div class="row">
                                    <div class="col">
                                        <div class="d-inline-block">
                                            <h6>Profit kontrahenta:&nbsp;</h6>
                                        </div>
                                        <div class="d-inline-block">
                                            <h4>{{ $customer->customer_code }}&nbsp;&nbsp;{{ $customer->customer_name }}</h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">

                                        <div class="d-inline-block">
                                            <h6>NIP:&nbsp;</h6>
                                        </div>
                                        <div class="d-inline-block">
                                            <h5>{{ $customer->customer_tin }}</h5>
                                        </div>
                                        <div class="d-inline-block ms-3">
                                            <h6>Kod:&nbsp;</h6>
                                        </div>
                                        <div class="d-inline-block">
                                            <h5>{{ $customer->customer_zipcode }}</h5>
                                        </div>
                                        <div class="d-inline-block ms-3">
                                            <h6>Miejscowość: </h6>
                                        </div>
                                        <div class="d-inline-block">
                                            <h5>{{ $customer->customer_city }}</h5>
                                        </div>
                                        <div class="d-inline-block ms-1">
                                            <h6>Ulica:&nbsp;</h6>
                                        </div>
                                        <div class="d-inline-block">
                                            <h5>{{ $customer->customer_address }}</h5>
                                        </div>

                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>

                    <div class="card-body">


                        <div class="row">
                            <div class="col-md-12">

                                <div class="d-inline-block">
                                    <label for="profitDateFrom">Okres od:&nbsp;</label>
                                </div>

                                <div class="d-inline-block">
                                    <input type='text' value="01.01.2020" class="form-control form-control-sm fs-5 input-datepicker"
                                           id='profitDateFrom'>
                                </div>

                                <div class="d-inline-block ms-2">
                                    <label for="profitDateTo">do:&nbsp;</label>
                                </div>

                                <div class="d-inline-block">
                                    <input type='text' value="01.01.2023" class="form-control form-control-sm fs-5 input-datepicker"
                                           id='profitDateTo'>
                                </div>

                                <div class="d-inline-block ms-2">
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary"
                                        id="btnShowProfit"
                                        data-profittype="customer"
                                        data-custid="{{ $customer->customer_id }}">
                                        <i class="bi bi-currency-dollar fs-6"></i>
                                    </button>
                                </div>

                            </div>

                        </div>


                        <div class="row">

                            <div class="accordion mt-3 _d-none" id="accordionAgreements">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingAgreement">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseAgreement"
                                                aria-expanded="true" aria-controls="collapseAgreement">
                                            <span class="fs-5">Umowy</span>
                                        </button>
                                    </h2>
                                    <div id="collapseAgreement" class="accordion-collapse collapse" aria-labelledby="headingAgreement"
                                         data-bs-parent="#accordionAgreements">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="agreementTable">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Nr</th>
                                                        <th scope="col" class="text-nowrap">Status umowy</th>
                                                        <th scope="col">Okres od</th>
                                                        <th scope="col">do</th>
                                                        <th scope="col">Oddział</th>
                                                        <th scope="col">Przychód</th>
                                                        <th scope="col">Koszt</th>
                                                        <th scope="col">Profit</th>
                                                        <th scope="col">GP</th>
                                                        <th scope="col">$</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($agreements as $a)
                                                        <tr>
                                                            <td>
                                                                <button
                                                                    type="button"
                                                                    class="border-0 show-doc"
                                                                    data-id="{{ $a->agr_id }}"
                                                                    data-doctypeid="1003"
                                                                >
                                                                    {{ $a->agr_no }}
                                                                </button>
                                                            </td>
                                                            <td>{{ $a->agr_status_name }}</td>
                                                            <td>{{ $a->agr_date_start }}</td>
                                                            <td>{{ $a->agr_date_end }}</td>
                                                            <td>{{ $a->agr_departament_name }}</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-sm fw-bold"
                                                                    data-agrid="{{ $a->agr_id }}">
                                                                    <i class="bi bi-search"></i>
                                                                </button>
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


                        {{--

                        <div class="row">

                            <div class="accordion mt-3 _d-none" id="accordionDevices">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingDevice">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDevice"
                                                aria-expanded="true" aria-controls="collapseDevice">
                                            <span class="fs-5">Urządzenia</span>
                                        </button>
                                    </h2>
                                    <div id="collapseDevice" class="accordion-collapse collapse" aria-labelledby="headingDevice"
                                         data-bs-parent="#accordionDevices">
                                        <div class="accordion-body">

                                            <div class="table-responsive">
                                                <table class="table table-striped table-sm table-hover" id="deviceTable">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Id</th>
                                                        <th scope="col">Nazwa</th>
                                                        <th scope="col">Nr seryjny</th>
                                                        <th scope="col">Przychód</th>
                                                        <th scope="col">Koszt</th>
                                                        <th scope="col">Profit</th>
                                                        <th scope="col">GP</th>
                                                        <th scope="col">#</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($devices as $device)
                                                        <tr>
                                                            <td>{{ $device->dev_id }}</td>
                                                            <td class="text-nowrap">{{ $device->dev_name }}</td>
                                                            <td class="text-nowrap">{{ $device->dev_serial_no }}</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>0</td>
                                                            <td>
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-sm fw-bold"
                                                                    data-devid="{{ $device->dev_id }}"
                                                                    data-agrid="{{ $agrId }}">
                                                                    <i class="bi bi-search"></i>
                                                                </button>
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

                        <div class="row">
                            <div class="accordion mt-3 _d-none" id="accordionSummary">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSummary">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseSummary"
                                                aria-expanded="false" aria-controls="collapseSummary">
                                            <span class="fw-bold fs-5">Podsumowanie umowy</span>
                                        </button>
                                    </h2>
                                    <div id="collapseSummary" class="accordion-collapse collapse" aria-labelledby="headingSummary"
                                         data-bs-parent="#accordionSummary">
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


                        </div>
                        --}}

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
