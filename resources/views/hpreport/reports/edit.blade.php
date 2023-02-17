@extends('hpreport.index')

@section('hprcontent')


    <!-- Modal -->
    <div class="modal fade modal-lg" id="changeCustomerModal" tabindex="-1" aria-labelledby="custModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="custModalLabel">Wybierz kontrahenta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-2 row">
                        <label class="col-sm-1 col-form-label text-end" for="customerName">Nazwa</label>
                        <div class="col-sm-11">
                            <div class="input-group">
                                <input type="text" class="form-control border-secondary" id="customerName" name="customerName">
                                <button class="btn btn-outline-secondary" type="button" data-toggle="hre_modalcustomerbtn">
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
                                <button class="btn btn-outline-secondary" type="button" data-toggle="hre_modalcustomerbtn">
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

                                <tbody data-toggle="hre_modalcustomertbody">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>

                            </table>
                        </div>

                    </div>
                    <div class="mb-2 row" data-toggle="hre_modalcustomeraddmessage"></div>
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
                        <div class="row">
                            <div class="col-md-2">
                                <h4>Raport {{ $reportNo }}</h4>
                            </div>
                            <div class="col-md-8" data-toggle="hre_reportupdatemessage"></div>
                            <div class="col-md-2">
                                <a href="#" class="btn btn-primary float-end" data-toggle="hre_reportupdate">Zapisz zmiany</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-reports">
                            <table class="table table-sm table-hover my-table" id="h_r_e_table">

                                <thead>
                                <tr class="text-start">

                                    <th scope="col" class="text-nowrap">Country</th>
                                    <th scope="col" class="text-nowrap">Partner ID</th>
                                    <th scope="col" class="text-nowrap">Partner Name</th>
                                    <th scope="col" class="text-nowrap">Start period</th>
                                    <th scope="col" class="text-nowrap">End period</th>

                                    <th scope="col" class="text-nowrap">HP Product Number</th>

                                    <th scope="col" class="text-nowrap">RC</th>

                                    <th scope="col" class="text-nowrap">Total Sellin Units</th>
                                    <th scope="col" class="text-nowrap">Inventory Units</th>
                                    <th scope="col" class="text-nowrap">Sales Units</th>
                                    <th scope="col" class="text-nowrap">Transaction Date</th>
                                    <th scope="col" class="text-nowrap">Channel Partner to Customer Invoice ID</th>

                                    <th scope="col" class="text-nowrap">Sold-to Customer ID</th>
                                    <th scope="col" class="text-nowrap">Sold To Customer Name</th>
                                    <th scope="col" class="text-nowrap">Sold To Company Tax ID</th>
                                    <th scope="col" class="text-nowrap">Sold To Address Line 1</th>
                                    <th scope="col" class="text-nowrap">Sold To Address Line 2</th>
                                    <th scope="col" class="text-nowrap">Sold To City</th>
                                    <th scope="col" class="text-nowrap">Sold To Postal Code</th>
                                    <th scope="col" class="text-nowrap">Sold To Country Code</th>

                                    <th scope="col" class="text-nowrap">Ship-to Customer ID</th>
                                    <th scope="col" class="text-nowrap">Ship To Customer Name</th>
                                    <th scope="col" class="text-nowrap">Ship To Company Tax ID</th>
                                    <th scope="col" class="text-nowrap">Ship To Address Line 1</th>
                                    <th scope="col" class="text-nowrap">Ship To Address Line 2</th>
                                    <th scope="col" class="text-nowrap">Ship To City</th>
                                    <th scope="col" class="text-nowrap">Ship To Postal Code</th>
                                    <th scope="col" class="text-nowrap">Ship To Country Code</th>

                                    <th scope="col" class="text-nowrap">Online</th>
                                    <th scope="col" class="text-nowrap">Customer Online Order Date</th>
                                    <th scope="col" class="text-nowrap">Sell From ID</th>
                                    <th scope="col" class="text-nowrap">Product Serial ID assigned by HP</th>

                                    <th scope="col" class="text-nowrap">Deal/Promo ID #1</th>
                                    <th scope="col" class="text-nowrap">Bundle ID #1</th>
                                    <th scope="col" class="text-nowrap">Deal/Promo ID #2</th>
                                    <th scope="col" class="text-nowrap">Bundle ID#2</th>
                                    <th scope="col" class="text-nowrap">Deal/Promo ID #3</th>
                                    <th scope="col" class="text-nowrap">Bundle ID#3</th>
                                    <th scope="col" class="text-nowrap">Deal/Promo ID #4</th>
                                    <th scope="col" class="text-nowrap">Bundle ID#4</th>
                                    <th scope="col" class="text-nowrap">Deal/Promo ID #5</th>
                                    <th scope="col" class="text-nowrap">Bundle ID#5</th>
                                    <th scope="col" class="text-nowrap">Deal/Promo ID #6</th>
                                    <th scope="col" class="text-nowrap">Bundle ID#6</th>

                                    <th scope="col" class="text-nowrap">Contract ID</th>
                                    <th scope="col" class="text-nowrap">Contract start date</th>
                                    <th scope="col" class="text-nowrap">Contract end date</th>
                                    <th scope="col" class="text-nowrap">Drop ship Flag</th>
                                    <th scope="col" class="text-nowrap">Partner Internal transaction ID</th>
                                    <th scope="col" class="text-nowrap">Partner Requested Rebate Amount</th>
                                    <th scope="col" class="text-nowrap">Partner Reference</th>
                                    <th scope="col" class="text-nowrap">Partner Comment</th>
                                    <th scope="col" class="text-nowrap">Partner Product Name</th>

                                </tr>
                                </thead>

                                @php
                                    $aId = 0;
                                    $paId = 0;
                                    $color1 = 'text-danger';
                                    $color2 = 'text-primary';
                                    $rowColor = $color1;
                                @endphp

                                <tbody>
                                @foreach($report as $row)

                                    @php
                                        $aId = $row->article_id;
                                        if($aId != $paId) {
                                             $rowColor = ($rowColor == $color1) ? $color2 : $color1;
                                         }
                                    @endphp

                                    <tr data-id="{{ $row->id }}"
                                        data-artid="{{ $aId }}"
                                        data-preiu="{{ $row->previous_iu}}"
                                        data-totsu="{{ $row->total_su }}"
                                        class="{{ $rowColor }}"
                                    >

                                        <td class="text-nowrap">{{ $row->{'Country'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Partner ID'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Partner Name'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Start period'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'End period'} }}</td>

                                        <td class="text-nowrap">{{ $row->{'HP Product Number'} }}</td>

                                        <td class="text-nowrap">
                                            <input type="hidden" value="{{ $row->row_status }}">
                                            <span class="row-status">
                                                @if($row->is_cohesive == 0)
                                                    <i class="text-danger bi bi-exclamation-triangle fs-5 fw-bold"></i>
                                                @endif
                                            </span>
                                        </td>

                                        <td class="text-nowrap">
                                            <input type="number"
                                                   data-id="{{ $row->id }}"
                                                   data-artid="{{ $aId }}"
                                                   data-toggle="artInpNumber"
                                                   data-prevval="{{ $row->{'Total Sellin Units'} }}"
                                                   value="{{ $row->{'Total Sellin Units'} }}"
                                                   @if(!$row->is_article_first_row or $row->row_type > 2) disabled @endif
                                                   name="tsu" min="-1000" max="1000">
                                        </td>

                                        <td class="text-nowrap">
                                            <input type="number"
                                                   data-id="{{ $row->id }}"
                                                   data-artid="{{ $aId }}"
                                                   data-repid="{{ $row->report_id }}"
                                                   data-toggle="artInpNumber"
                                                   data-fr="{{ $row->is_article_first_row }}"
                                                   value="{{ $row->{'Inventory Units'} }}"
                                                   name="iu" min="0" max="1000"
                                                   @if(!$row->is_article_first_row) disabled @endif>
                                        </td>

                                        <td class="text-nowrap">
                                            <input type="number"
                                                   data-id="{{ $row->id }}"
                                                   data-artid="{{ $aId }}"
                                                   data-prevval="{{ $row->{'Sales Units'} }}"
                                                   value="{{ $row->{'Sales Units'} }}"
                                                   data-toggle="artInpNumber"
                                                   name="su" min="-1000" max="1000"
                                                   @if((!$row->is_article_first_row and $row->row_type != 1) or $row->row_type != 1)
                                                   disabled
                                                @endif>
                                        </td>

                                        <td class="text-nowrap">{{ $row->{'Transaction Date'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Channel Partner to Customer Invoice ID'} }}</td>

                                        <td class="text-nowrap">
                                            <input type="hidden" name="customerid" value="{{ $row->customer_id }}">
                                            @if(!$row->customer_id == 0)
                                                <input type="text" value="{{ $row->{'Sold-to Customer ID'} }}" name="customer" class="custCodeInp"
                                                       disabled>
                                                <button class="btn btn-sm"
                                                        data-id="{{ $row->id }}"
                                                        data-artid="{{ $aId }}"
                                                        data-custid="{{ $row->customer_id }}"
                                                        data-toggle="artInpCustomer">
                                                    <i class="bi-pencil"></i>
                                                </button>
                                            @endif
                                        </td>

                                        <td class="text-nowrap" data-toggle="cname">{{ $row->{'Sold To Customer Name'} }}</td>
                                        <td class="text-nowrap" data-toggle="ctin">{{ $row->{'Sold To Company Tax ID'} }}</td>
                                        <td class="text-nowrap" data-toggle="caddr">{{ $row->{'Sold To Address Line 1'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Sold To Address Line 2'} }}</td>
                                        <td class="text-nowrap" data-toggle="ccity">{{ $row->{'Sold To City'} }}</td>
                                        <td class="text-nowrap" data-toggle="czip">{{ $row->{'Sold To Postal Code'} }}</td>
                                        <td class="text-nowrap" data-toggle="ccountry">{{ $row->{'Sold To Country Code'} }}</td>

                                        <td class="text-nowrap" data-toggle="ccode">{{ $row->{'Ship-to Customer ID'} }}</td>
                                        <td class="text-nowrap" data-toggle="cname">{{ $row->{'Ship To Customer Name'} }}</td>
                                        <td class="text-nowrap" data-toggle="ctin">{{ $row->{'Ship To Company Tax ID'} }}</td>
                                        <td class="text-nowrap" data-toggle="caddr">{{ $row->{'Ship To Address Line 1'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Ship To Address Line 2'} }}</td>
                                        <td class="text-nowrap" data-toggle="ccity">{{ $row->{'Ship To City'} }}</td>
                                        <td class="text-nowrap" data-toggle="czip">{{ $row->{'Ship To Postal Code'} }}</td>
                                        <td class="text-nowrap" data-toggle="ccountry">{{ $row->{'Ship To Country Code'} }}</td>

                                        <td class="text-nowrap">{{ $row->{'Online'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Customer Online Order Date'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Sell From ID'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Product Serial ID assigned by HP'} }}</td>

                                        <td class="text-nowrap">{{ $row->{'Deal/Promo ID #1'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Bundle ID #1'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Deal/Promo ID #2'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Bundle ID #2'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Deal/Promo ID #3'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Bundle ID #3'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Deal/Promo ID #4'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Bundle ID #4'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Deal/Promo ID #5'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Bundle ID #5'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Deal/Promo ID #6'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Bundle ID #6'} }}</td>

                                        <td class="text-nowrap" data-toggle="ccontract">{{ $row->{'Contract ID'} }}</td>
                                        <td class="text-nowrap" data-toggle="ccontracts">{{ $row->{'Contract start date'} }}</td>
                                        <td class="text-nowrap" data-toggle="ccontracte">{{ $row->{'Contract end date'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Drop ship Flag'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Partner Internal transaction ID'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Partner Requested Rebate Amount'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Partner Reference'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Partner Comment'} }}</td>
                                        <td class="text-nowrap">{{ $row->{'Partner Product Name'} }}</td>

                                    </tr>

                                    @php($paId = $aId)

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

