import {ax, isObjectEmpty, showMessage, digitForm, showWorkCard} from "../functions.js";


// ##### global functions #####


// blokada ekranu podczas długich zapytań ajax
const $overlaySpinner = $("#overlay-spinner");

// pudełka na komunikaty
const $devMessageBox = $(".result-message", $('#bok-devices'));
$devMessageBox.hide();

const $reviewMessageBox = $(".result-message", $('#bok-review'));
$reviewMessageBox.hide();


function agreementDevices(agrNo, dTable, callback) {
    console.log('agreementDevices');
    ax(
        {agrNo: agrNo},
        '/bok/contracts/getAgreementId',
        function (data) {
            //console.log('agrId = ' + data.agrId);
            ax(
                {agrId: parseInt(data.agrId)},
                '/bok/contracts/getAgreementDevices',
                function (devices) {
                    //console.log('devices:');
                    //console.log(devices);
                    callback.apply(this, [dTable, devices]);
                }
            );
        }
    );
}

function getDeviceBySerial(serialNo, $destination, callback) {
    console.log('getDeviceBySerial');
    ax(
        {serialNo: serialNo},
        '/bok/devices/getDeviceBySerial',
        function (device) {
            //console.log(device);
            callback.apply(this, [$destination, device]);
        }
    );
}

function getDevices(params, $destination, callback) {
    console.log('getDevices params:');
    console.log(params);
    $overlaySpinner.fadeIn(300);
    ax(
        params,
        '/bok/devices/getDevices',
        function (devices) {
            //console.log(devices);
            callback.apply(this, [$destination, devices]);
            $overlaySpinner.fadeOut(300);
        }
    );
}

function getDeviceModels(params, $destination, callback) {
    console.log('getDeviceModels');
    $overlaySpinner.fadeIn(300);
    ax(
        params,
        '/bok/devices/getDeviceModels',
        function (data) {
            console.log(data);
            callback.apply(this, [$destination, data]);
            $overlaySpinner.fadeOut(300);
        }
    );
}


// ##### Agreements #####

// ===== obsługa zakładki 'Fakturowanie gdy brak licznika' =====
class BillingIfNoCounter {

    "use strict";

    constructor(accordionId, itemId) {
        this.$accordion = $('#' + accordionId);
        this.$item = $('#' + itemId, this.$accordion);
        this.$agreementNoInput = $('input[name=agreementNo]', this.$item);
        this.$btnSearch = $('#btn-search', this.$item);
        this.$btnSave = $('#btn-save', this.$item);
        this.$deviceTable = $('#deviceTable', this.$item);
        this.$radioYes = $('#radioYes', this.$item);
        this.$radioNo = $('#radioNo', this.$item);

        this.$radioYes.on('change', e => {
            $('input[type=checkbox]', this.$deviceTable).prop('checked', true);
        });

        this.$radioNo.on('change', e => {
            $('input[type=checkbox]', this.$deviceTable).prop('checked', false);
        });

        //dom: "<'row'<'col-md-6 ml-auto'f>>t<'row'<'col-md-6'i><'col-md-4 ml-auto'p>><'clear'>",
        this.deviceTable = this.$deviceTable.DataTable(
            {
                dom: "<'row'<'col-md-12 mt-1'f>>",
                paging: false,
                autoWidth: false,
                searching: true,
                ordering: true,
                rowId: 'agr_item_id',
                columns: [
                    {'data': 'dev_id'},
                    {'data': 'dev_name', 'className': 'ellipis text-nowrap'},
                    {'data': 'dev_serial_no'},
                    {'data': 'dev_status'},
                    {'data': 'dev_billing_if_no_counter'},
                    {'data': 'action', 'className': 'text-center'},
                ],
            }
        );
        this.deviceTable.draw();

        this.$btnSearch.on('click', this.showAgreementDevices.bind(this));
        this.$btnSave.on('click', this.save.bind(this));
    }

    showAgreementDevices = function () {
        console.log('showAgreementDevices');
        const agrNo = this.$agreementNoInput.val();
        agreementDevices(agrNo, this.deviceTable, this.refreshDeviceTable);
    };

    refreshDeviceTable = function (dTable, devices) {
        for (let n in devices) {
            let item = devices[n];
            let yes = false;
            let i = item.dev_billing_if_no_counter;
            switch (i) {
                case '1':
                    item.dev_billing_if_no_counter = 'tak';
                    yes = true;
                    break;
                case '2':
                    item.dev_billing_if_no_counter = 'nie';
                    break;
                default:
                    item.dev_billing_if_no_counter = 'Nie wybrano';
            }
            item.action = '<input class="form-check-input" type="checkbox"';
            item.action += ' data-itemid="' + item.agr_item_id + '"';
            item.action += ' data-agrid="' + item.agr_id + '"';
            item.action += (yes) ? ' checked>' : '>';
        }
        dTable.clear();
        dTable.rows.add(devices).draw();
    };

    save = function () {
        console.log('save');
        const deviceTable = this.deviceTable;
        const data = {};

        // wyciągamy z tabeli parametr fgbl - 'Fakturowanie gdy brak licznika'
        $('input[type=checkbox]', this.$deviceTable).each(
            function (index) {
                const $this = $(this);
                data[index] = {
                    agrId: parseInt($this.data('agrid')),
                    itemId: parseInt($this.data('itemid')),
                    fgbl: $this.prop('checked') ? 1 : 2
                }
            }
        );

        if (!isObjectEmpty(data)) {
            ax(
                {data: data},
                '/bok/contracts/updateAgreementDevicesFGBL',
                function (data) {
                    //console.log(data);
                    if (!isObjectEmpty(data)) {
                        // aktualizujemy tabelę urządzeń
                        for (let n in data) {
                            let item = data[n];
                            let fgbl = (parseInt(item.fgbl) === 1) ? 'tak' : 'nie';
                            // kolumna FGBL
                            let cell = deviceTable.cell('#' + item.itemId, 4);
                            cell.data(fgbl).draw();
                            // kolumna Tak
                            cell = deviceTable.cell('#' + item.itemId, 5).node();
                            if (fgbl === 'tak') {
                                $(cell).find('input').prop('checked', true);
                            } else {
                                $(cell).find('input').prop('checked', false);
                            }
                        }
                    }
                }
            )
        }
    };
}

// ===== obsługa zakładki 'Rodzaj części zamiennych' na umowach =====
class ReplacementPartsKindOnAgreement {

    "use strict";

    constructor(accordionId, itemId) {
        this.$accordion = $('#' + accordionId);
        this.$item = $('#' + itemId, this.$accordion);
        this.$agreementNoInput = $('input[name=agreementNo]', this.$item);
        this.$partsKind = $('select[name=partsKind]', this.$item);
        this.$btnSearch = $('#btn-search', this.$item);
        this.$btnSave = $('#btn-save', this.$item);
        this.$btnCheck = $('#btn-check', this.$item);
        this.$deviceTable = $('#deviceTable', this.$item);

        this.deviceTable = this.$deviceTable.DataTable(
            {
                paging: false,
                autoWidth: false,
                searching: true,
                ordering: true,
                rowId: 'agr_item_id',
                columns: [
                    {'data': 'dev_id'},
                    {'data': 'dev_name', 'className': 'ellipis text-nowrap'},
                    {'data': 'dev_serial_no'},
                    {'data': 'dev_status'},
                    {'data': 'dev_replacement_parts_kind_name'},
                    {'data': 'action', 'className': 'text-center'},

                ],
                //dom: "<'row'<'col-md-12 mt-1'f>>",
                //dom: '<"top">rt<"bottom"flp>' // przeniesienie Search na dół
            }
        );
        this.deviceTable.draw();

        this.$btnSearch.on('click', this.showAgreementDevices.bind(this));
        this.$btnCheck.on('click', this.setPartsKind.bind(this));
        this.$btnSave.on('click', this.save.bind(this));
    }

    showAgreementDevices = function () {
        console.log('showAgreementDevices');
        const agrNo = this.$agreementNoInput.val();
        agreementDevices(agrNo, this.deviceTable, this.refreshDeviceTable);
    };

    setPartsKind = function () {
        console.log('setPartsKind');
        const partsKind = parseInt(this.$partsKind.val());
        $('select', this.$deviceTable).each(
            function (index) {
                $(this).val(partsKind);
            }
        );
    };

    refreshDeviceTable = function (dTable, devices) {
        console.log('refreshDeviceTable');
        ax(
            {},
            '/bok/contracts/getDeviceReplacementParts',
            function (parts) {
                for (let n in devices) {
                    let item = devices[n];
                    let partsId = parseInt(item.dev_replacement_parts_kind_id);
                    item.action = '<select';
                    item.action += ' data-itemid="' + item.agr_item_id + '"';
                    item.action += ' data-agrid="' + item.agr_id + '"';
                    item.action += '>';
                    for (let k in parts) {
                        let o = parts[k];
                        let selected = (partsId === parseInt(o.dic_field_id)) ? 'selected = "selected"' : '';
                        item.action += '<option value="' + o.dic_field_id + '"' + selected + '>' + o.dic_field_name + '</option>';
                    }
                    item.action += '</select>';
                }
                dTable.clear();
                dTable.rows.add(devices).draw();
            }
        );
    };

    save = function () {
        console.log('save');
        const data = {};
        const deviceTable = this.deviceTable;

        $('select', this.$deviceTable).each(
            function (index) {
                const $this = $(this);
                data[index] = {
                    agrId: parseInt($this.data('agrid')),
                    itemId: parseInt($this.data('itemid')),
                    rpk: parseInt($this.val()),
                    rpkName: $this.find('option:selected').text()
                }
            }
        );
        //console.log(data);
        if (!isObjectEmpty(data)) {
            ax(
                {data: data},
                '/bok/devices/updateDevicesRPK',
                function (data) {
                    //console.log(data);
                    if (!isObjectEmpty(data)) {
                        // aktualizujemy tabelę urządzeń
                        for (let n in data) {
                            let item = data[n];
                            //let fgbl = (parseInt(item.fgbl) === 1) ? 'tak' : 'nie';
                            let rpk = parseInt(item.rpk);
                            let rpkName = item.rpkName;
                            // kolumna RCZ
                            let cell = deviceTable.cell('#' + item.itemId, 4);
                            cell.data(rpkName).draw();
                            // kolumna #
                            let $cell = $(deviceTable.cell('#' + item.itemId, 5).node());
                            $('option', $cell).each(function () {
                                $(this).removeAttr('selected');
                            });
                            $('select', $cell).val(rpk);
                        }
                    }
                }
            )
        }
    };

}


// ##### Devices #####

// ===== obsługa zakładki 'Zmiana modelu' =====

class DeviceModelChange {
    "use strict";

    constructor(accordionId, itemId) {
        this.$accordion = $('#' + accordionId);
        this.$item = $('#' + itemId, this.$accordion);
        this.$serialNoInput = $('input[name=serialNo]', this.$item);
        this.$devNameInput = $('input[name=devName]', this.$item);
        this.$devKindInput = $('select[name=kind]', this.$item);
        this.$typeInput = $('select[name=type]', this.$item);
        this.$producerInput = $('select[name=producer]', this.$item);
        this.$modelInput = $('select[name=model]', this.$item);
        this.$btnSearch = $('#btn-search', this.$item);
        this.$btnSearchModel = $('#btn-search-model', this.$item);
        this.$btnSave = $('#btn-save', this.$item);
        //

        this.$btnSearch.on('click', this.showDevice.bind(this));
        this.$btnSearchModel.on('click', this.getModels.bind(this));
        this.$btnSave.on('click', this.save.bind(this));
    }

    getModels = function () {
        console.log('getDeviceModels');
        const params = {
            kind: Number(this.$devKindInput.val()),
            type: Number(this.$typeInput.val()),
            producer: Number(this.$producerInput.val()),
        };
        getDeviceModels(params, this.$modelInput, this.refreshModels);
    };

    refreshModels = function ($select, data) {
        console.log('refreshModels');
        $select.html('');
        $select.append('<option value="0">--- Nie wybrano ---</option>');
        for (let n in data) {
            let item = data[n];
            $select.append('<option value="' + item.dic_field_id + '">' + item.dic_field_name + '</option>');
        }
    };

    showDevice = function () {
        console.log('showDevice');
        const serialNo = this.$serialNoInput.val();
        getDeviceBySerial(serialNo, this.$devNameInput, this.refreshDevice);
    };

    refreshDevice = function ($destination, device) {
        console.log('refreshDevice');
        //console.log(device);
        $destination.val('');
        $destination.attr('value', '');
        $destination.attr('data-itemid', 0);
        $destination.attr('data-serialno', '');
        if (device.length !== 1) {
            Swal.fire({
                title: 'Nie odnaleziono urządzenia.',
                icon: 'warning',
                confirmButtonText: 'Zamknij',
            })
        } else {
            //console.log(device[0].dev_id);
            $destination.val(device[0].dev_name);
            $destination.attr('value', device[0].dev_name);
            $destination.attr('data-itemid', device[0].dev_id);
            $destination.attr('data-serialno', device[0].dev_serial_no);
        }
    };

    save = function () {
        console.log('save');
        const $devName = this.$devNameInput;
        const o = {
            data: {
                modelId: Number(this.$modelInput.val()),
                modelName: this.$modelInput.find('option:selected').text(),
                devId: Number(this.$devNameInput.data('itemid')),
                devSerial: this.$devNameInput.data('serialno'),
                devName: this.$devNameInput.val()
            }
        };

        if (o.data.devId > 0 && o.data.modelId > 0) {
            Swal.fire({
                title: 'Zamienić model:<h3>' + o.data.devName + '</h3>na<h3>' + o.data.modelName + '</h3>?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tak',
                cancelButtonText: 'Nie'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(o);
                    ax(
                        o,
                        '/bok/devices/updateDeviceModel',
                        function (data) {
                            //console.log(data);
                            $devName.val(data.model_name);
                            $devName.attr('value', data.model_name);
                        }
                    );
                }
            })
        }

    }

}

// ===== obsługa zakładki 'Rodzaj części zamiennych' =====

class ReplacementPartsKind {

    "use strict";

    constructor(accordionId, itemId) {
        this.$accordion = $('#' + accordionId);
        this.$item = $('#' + itemId, this.$accordion);
        this.$departmentInput = $('select[name=department]', this.$item);
        this.$modelInput = $('select[name=model]', this.$item);
        this.$devKindInput = $('select[name=kind]', this.$item);
        this.$zipCodeInput = $('input[name=zipcode]', this.$item);
        this.$partsKindInput = $('select[name=partsKind]', this.$item);

        this.$btnGetDev = $('#btn-get-dev', this.$item);
        this.$btnCheck = $('#btn-check', this.$item);
        this.$btnSave = $('#btn-save', this.$item);

        this.$deviceTable = $('#deviceTable', this.$item);
        this.deviceTable = this.$deviceTable.DataTable(
            {
                paging: false,
                autoWidth: false,
                searching: true,
                ordering: true,
                rowId: 'agr_item_id',
                columns: [
                    {'data': 'dev_name', 'className': 'ellipis text-nowrap'},
                    {'data': 'dev_serial_no'},
                    {'data': 'dev_tech_person_name'},
                    {'data': 'dev_address'},
                    {'data': 'dev_replacement_parts_kind_name'},
                    {'data': 'action', 'className': 'text-center', 'orderable': false},
                ],
                //dom: "<'row'<'col-md-12 mt-1'f>>",
                //dom: '<"top">rt<"bottom"flp>' // przeniesienie Search na dół
            }
        );
        this.deviceTable.draw();

        this.$btnGetDev.on('click', this.showDevices.bind(this));
        this.$btnCheck.on('click', this.setPartsKind.bind(this));
        this.$btnSave.on('click', this.save.bind(this));
        this.$devKindInput.on('change', this.getModels.bind(this));
    }

    getModels = function () {
        console.log('getDeviceModels');
        const params = {
            kind: Number(this.$devKindInput.val()),
        };
        getDeviceModels(params, this.$modelInput, this.refreshModels);
    };

    refreshModels = function ($select, data) {
        console.log('refreshModels');
        $select.html('');
        $select.append('<option value="0">--- Nie wybrano ---</option>');
        for (let n in data) {
            let item = data[n];
            $select.append('<option value="' + item.dic_field_id + '">' + item.dic_field_name + '</option>');
        }
    };

    showDevices = function () {
        console.log('showAgreementDevices');
        const params = {
            departmentId: Number(this.$departmentInput.val()),
            modelId: Number(this.$modelInput.val()),
            deviceKindId: Number(this.$devKindInput.val()),
            zipCode: this.$zipCodeInput.val()
        };
        getDevices(params, this.deviceTable, this.refreshDeviceTable);
    };

    setPartsKind = function () {
        console.log('setPartsKind');
        const partsKind = parseInt(this.$partsKindInput.val());
        $('select', this.$deviceTable).each(
            function (index) {
                $(this).val(partsKind);
            }
        );
    };

    refreshDeviceTable = function (dTable, devices) {
        console.log('refreshDeviceTable');
        ax(
            {},
            '/bok/contracts/getDeviceReplacementParts',
            function (parts) {
                for (let n in devices) {
                    let item = devices[n];
                    let partsId = parseInt(item.dev_replacement_parts_kind_id);
                    item.action = '<select';
                    item.action += ' data-itemid="' + item.agr_item_id + '"';
                    item.action += ' data-agrid="' + item.agr_id + '"';
                    item.action += '>';
                    for (let k in parts) {
                        let o = parts[k];
                        let selected = (partsId === parseInt(o.dic_field_id)) ? 'selected = "selected"' : '';
                        item.action += '<option value="' + o.dic_field_id + '"' + selected + '>' + o.dic_field_name + '</option>';
                    }
                    item.action += '</select>';
                }
                dTable.clear();
                dTable.rows.add(devices).draw();
            }
        );
    };

    save = function () {
        console.log('save');
        const data = {};
        const deviceTable = this.deviceTable;
        let counter = 0;

        $('select', this.$deviceTable).each(
            function (index) {
                const $this = $(this);
                data[index] = {
                    agrId: parseInt($this.data('agrid')),
                    itemId: parseInt($this.data('itemid')),
                    rpk: parseInt($this.val()),
                    rpkName: $this.find('option:selected').text()
                }
            }
        );
        for (let n in data) {
            ++counter;
        }
        //console.log(data);
        if (!isObjectEmpty(data)) {
            Swal.fire({
                title: 'Zamienić rodzaj cześci zamiennych dla ' + counter + ' urządzeń?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tak',
                cancelButtonText: 'Nie'
            }).then((result) => {
                if (result.isConfirmed) {
                    ax(
                        {data: data},
                        '/bok/devices/updateDevicesRPK',
                        function (data) {
                            console.log(data);
                            if (!isObjectEmpty(data)) {
                                // aktualizujemy tabelę urządzeń
                                for (let n in data) {
                                    let item = data[n];
                                    //let fgbl = (parseInt(item.fgbl) === 1) ? 'tak' : 'nie';
                                    let rpk = parseInt(item.rpk);
                                    let rpkName = item.rpkName;
                                    // kolumna RCZ
                                    let cell = deviceTable.cell('#' + item.itemId, 4);
                                    cell.data(rpkName).draw();
                                    // kolumna #
                                    let $cell = $(deviceTable.cell('#' + item.itemId, 5).node());
                                    $('option', $cell).each(function () {
                                        $(this).removeAttr('selected');
                                    });
                                    $('select', $cell).val(rpk);
                                }
                            }
                        }
                    )
                }
            })
        }
    };

}

// ===== obsługa zakładki 'Podmiana techników obsługujących urządzenia' =====

class ExchangeTechnicianByTechnician {

    constructor(accordionId, itemId) {

        this.$accordion = $('#' + accordionId);
        this.$item = $('#' + itemId, this.$accordion);
        this.$technicianOldInput = $('select[name=technician-old]', this.$item);
        this.$technicianNewInput = $('select[name=technician-new]', this.$item);
        this.$btnCheck = $('#btn-check', this.$item);
        this.$btnSave = $('#btn-save', this.$item);

        this.$deviceTable = $('#deviceTable', this.$item);
        this.deviceTable = this.$deviceTable.DataTable(
            {
                paging: true,
                autoWidth: false,
                searching: false,
                ordering: true,
                rowId: 'agr_item_id',
                columns: [
                    {'data': 'dev_name'},
                    {'data': 'dev_serial_no'},
                    {'data': 'agr_no'},
                    {'data': 'dev_address'},
                    {'data': 'cust_name', 'className': 'ellipis text-nowrap'},
                ],
            }
        );
        this.deviceTable.draw();

        this.$btnCheck.on('click', this.showDevices.bind(this));
        this.$btnSave.on('click', this.save.bind(this));

    }

    showDevices = function () {
        console.log('showAgreementDevices');
        const technician = parseInt(this.$technicianOldInput.val());
        if (technician !== 0) {
            const params = {
                technicianId: technician
            };
            getDevices(params, this.deviceTable, this.refreshDeviceTable);
        }
    };

    refreshDeviceTable = function (dTable, devices) {
        console.log('refreshDeviceTable');
        dTable.clear();
        dTable.rows.add(devices).draw();
    };

    save = function () {
        console.log('save');
        const dTable = this.deviceTable;
        const count = dTable.data().length;

        const technicianOldInput = this.$technicianOldInput;
        const technicianNewInput = this.$technicianNewInput;
        const technicianOld = parseInt(technicianOldInput.val());
        const technicianNew = parseInt(technicianNewInput.val());

        if (technicianOld !== 0 && technicianNew !== 0 && count !== 0) {
            const o = {
                data: {
                    technicianOld: technicianOld,
                    technicianNew: technicianNew,
                }
            };
            //console.log(o);
            Swal.fire({
                title: 'Zamienić technika dla ' + count + ' urządzeń?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tak',
                cancelButtonText: 'Nie'
            }).then((result) => {
                if (result.isConfirmed) {
                    $overlaySpinner.fadeIn(300);
                    ax(
                        o,
                        '/bok/devices/updateDevicesTechByTech',
                        function (data) {
                            technicianOldInput.val(technicianNew);
                            technicianNewInput.val(0);
                            $overlaySpinner.fadeOut(300);
                            showMessage($devMessageBox, 'Zakończono aktualizację techników.');
                        }
                    );
                }
            })

        }
    }

}

// ===== obsługa zakładki 'Zmiana technika obsługującego urządzenie' =====

class UpdateDevicesTechnician {

    constructor(accordionId, itemId) {

        this.$accordion = $('#' + accordionId);
        this.$item = $('#' + itemId, this.$accordion);
        this.$technicianOldInput = $('select[name=technician-old]', this.$item);
        this.$technicianNewInput = $('select[name=technician-new]', this.$item);
        this.$departmentInput = $('select[name=department]', this.$item);
        this.$devKindInput = $('select[name=dewKind]', this.$item);
        this.$zipCodeInput = $('input[name=zipcode]', this.$item);
        this.$btnCheck = $('#btn-check', this.$item);
        this.$btnSave = $('#btn-save', this.$item);

        this.$deviceTable = $('#deviceTable', this.$item);
        this.deviceTable = this.$deviceTable.DataTable(
            {
                paging: true,
                autoWidth: false,
                searching: true,
                ordering: true,
                rowId: 'agr_item_id',
                columns: [
                    {'data': 'dev_name'},
                    {'data': 'dev_serial_no'},
                    {'data': 'agr_no'},
                    {'data': 'dev_address'},
                    {'data': 'cust_name', 'className': 'ellipis text-nowrap'},
                ],
            }
        );
        this.deviceTable.draw();

        this.$btnCheck.on('click', this.showDevices.bind(this));
        this.$btnSave.on('click', this.save.bind(this));
    }

    showDevices = function () {
        console.log('showAgreementDevices');
        const params = {
            departmentId: Number(this.$departmentInput.val()),
            technicianId: Number(this.$technicianOldInput.val()),
            deviceKindId: Number(this.$devKindInput.val()),
            zipCode: this.$zipCodeInput.val()
        };
        //console.log(params);
        getDevices(params, this.deviceTable, this.refreshDeviceTable);
    };

    refreshDeviceTable = function (dTable, devices) {
        console.log('refreshDeviceTable');
        dTable.clear();
        dTable.rows.add(devices).draw();
    };

    save = function () {

        console.log('save');
        const dTable = this.deviceTable;
        const count = dTable.data().length;
        const $technicianNewInput = this.$technicianNewInput;
        const technicianNew = parseInt($technicianNewInput.val());
        const data = {};


        if (technicianNew !== 0 && count !== 0) {
            dTable.rows().every(function (rowIdx, tableLoop, rowLoop) {
                const d = this.data();
                // const n = this.node();
                data[rowLoop] = {
                    agrItemId: parseInt(d.agr_item_id),
                    itemId: parseInt(d.dev_id),
                    technicianNew: technicianNew,
                };
            });
            //console.log(data);
            Swal.fire({
                title: 'Zamienić technika dla ' + count + ' urządzeń?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Tak',
                cancelButtonText: 'Nie'
            }).then((result) => {
                if (result.isConfirmed) {
                    $overlaySpinner.fadeIn(300);
                    ax(
                        {data: data},
                        '/bok/devices/updateDevicesTechnician',
                        function (data) {
                            //console.log(data);
                            dTable.clear().draw();
                            $technicianNewInput.val(0);
                            $overlaySpinner.fadeOut(300);
                            showMessage($devMessageBox, 'Zakończono aktualizację techników.');
                        }
                    )
                }
            })
        }
    }

}

// ===== obsługa zakładki 'Brak adresu instalacji' =====

class UpdateInstallationAddress {

    constructor(accordionId, itemId) {

        const updateAddress = this.updateAddress;
        const dTable = this.deviceTable;

        this.$accordion = $('#' + accordionId);
        this.$item = $('#' + itemId, this.$accordion);
        this.$departmentInput = $('select[name=department]', this.$item);
        this.$agrKindInput = $('select[name=agrKind]', this.$item);
        this.$problemInput = $('select[name=problem]', this.$item);

        this.$btnCheck = $('#btn-check', this.$item);

        this.$deviceTable = $('#deviceTable', this.$item);
        this.deviceTable = this.$deviceTable.DataTable(
            {
                paging: true,
                autoWidth: false,
                searching: false,
                ordering: true,
                rowId: 'agr_item_id',
                columns: [
                    {'data': 'dev_name'},
                    {'data': 'dev_serial_no'},
                    {'data': 'agr_no'},
                    {'data': 'cust_name'},
                    {'data': 'dev_address'},
                    {'data': 'dev_address_status'},
                ],
                "columnDefs": [
                    {
                        "targets": 4,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).attr('name', 'addr')
                        },
                    },
                    {
                        "targets": 5,
                        "createdCell": function (td, cellData, rowData, row, col) {
                            $(td).attr('name', 'addrStatus')
                        },
                    }
                ],
                'createdRow': function (row, data, dataIndex) {
                    const $row = $(row);
                    $row.addClass('active-row');
                    $row.off('click');
                    $row.on('click', updateAddress);
                }
            }
        );
        this.deviceTable.draw();

        this.$btnCheck.on('click', this.showDevices.bind(this));
    }

    showDevices = function () {
        console.log('showDevices');
        const dTable = this.deviceTable;
        const params = {
            departmentId: Number(this.$departmentInput.val()),
            agrKindId: Number(this.$agrKindInput.val()),
            problemId: Number(this.$problemInput.val()),
        };
        $overlaySpinner.fadeIn(300);
        //console.log(params);
        ax(
            params,
            '/bok/devices/getDevicesWithoutInstallationAddress',
            function (devices) {
                //console.log(devices);
                dTable.clear();
                dTable.rows.add(devices).draw();
                $overlaySpinner.fadeOut(300);
            }
        );
    };

    updateAddress = function () {
        console.log('updateAddress');
        const row = this;
        const $row = $(this);
        const agrItemId = Number($row.attr('id'));

        const modalEl = document.querySelector('#modal-bok-updateInstallationAddress');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        const $modal = $('#modal-bok-updateInstallationAddress');

        const $devName = $('input[name=devName]', $modal);
        const $custName = $('input[name=custName]', $modal);
        const $devAddress = $('input[name=devAddress]', $modal);
        const $btnSave = $('button[name=save]', $modal);

        const $table = $('#addressTable', $modal);
        const table = $table.DataTable(
            {
                paging: true,
                autoWidth: false,
                searching: true,
                ordering: true,
                rowId: 'addr_d_id',
                columns: [
                    {'data': 'addr_type_name'},
                    {'data': 'addr_default'},
                    {'data': 'cust_zipcode'},
                    {'data': 'cust_city'},
                    {'data': 'cust_street'},
                ],
                'createdRow': function (row, data, dataIndex) {
                    //console.log(data);
                    const $row = $(row);
                    $row.data('addrDataId', data.addr_d_id);
                    $row.data('address', data.cust_zipcode + ' ' + data.cust_city + ' ' + data.cust_street);
                    $row.addClass('active-row');
                    $row.off('click');
                    $row.on('click', function () {
                        const $this = $(this);
                        $devAddress.val($this.data('address'));
                        $devAddress.data('addrDataId', $this.data('addrDataId'));
                    });
                }
            }
        );
        table.draw();

        const modalClean = function () {
            console.log('modal hidden');
            table.destroy();
            $btnSave.off('click');
            $devName.val('');
            $custName.val('');
            $devAddress.val('');
            $devAddress.data('agrItemId', 0);
            $devAddress.data('addrDataId', 0);
            modalEl.removeEventListener('hidden.bs.modal', modalClean);
        };
        modalEl.addEventListener('hidden.bs.modal', modalClean);

        $btnSave.on('click', function () {
            console.log('save');
            const o = {
                data: {
                    agrItemId: Number($devAddress.data('agrItemId')),
                    addrDataId: Number($devAddress.data('addrDataId')),
                }
            };
            ax(
                o,
                '/bok/devices/updateDeviceInstallationAddress',
                function (data) {
                    //console.log(data);
                    if (parseInt(data.ROWCOUNT) === 1) {
                        showMessage($devMessageBox, 'Adres instalacji został uaktualniony.');
                        $row.find('td[name=addr]').text($devAddress.val());
                        $row.find('td[name=addrStatus]').text('aktywny');
                    }
                    modal.hide();
                }
            );
        });

        ax(
            {agrItemId: agrItemId},
            '/bok/devices/getDeviceAddresses',
            function (data) {
                console.log(data.dev);
                $devName.val(data.dev.dev_name + ' -- ' + data.dev.dev_serial_no);
                $custName.val(data.dev.cust_name);
                $devAddress.data('agrItemId', data.dev.agr_item_id);
                table.clear();
                table.rows.add(data.addr).draw();
                modal.show();
            }
        );

    };


}


// ##### Review #####

class DeviceMaintenanceService {

    constructor(moduleId, containerId) {
        const deviceInfo = this.deviceInfo;
        this.$module = $('#' + moduleId);
        this.$container = $('#' + containerId, this.$module);
        this.$isSetGuaranteeDateRadio = $('input[id=radio-yes-1]', this.$container);
        this.$isUnderWarrantyRadio = $('input[id=radio-yes-2]', this.$container);
        this.$departmentSelect = $('select[name=department]', this.$container);
        this.$agrTypeSelect = $('select[name=agr-type]', this.$container);
        this.$technicianSelect = $('select[name=technician]', this.$container);
        this.$yearSelect = $('select[name=year]', this.$container);
        this.$monthSelect = $('select[name=month]', this.$container);
        this.$btnSearch = $('#btn-search', this.$container);

        const $monthSelect = this.$monthSelect;
        const $yearSelect = this.$yearSelect;

        this.$deviceTable = $('#deviceTable', this.$container);
        this.deviceTable = this.$deviceTable.DataTable(
            {
                paging: true,
                autoWidth: false,
                searching: true,
                ordering: true,
                rowId: 'dev_id',
                columns: [
                    {'data': 'dev_name'},
                    {'data': 'dev_serial_no'},
                    {'data': 'cust_name', 'className': 'ellipis text-nowrap'},
                    //{'data': 'dev_tech_person_name'},
                    {'data': 'dev_service_company_unit_name'},
                    {'data': 'dev_guarantee_date_dks'},
                    {'data': 'dev_last_review_date'},
                    {'data': 'dev_days_at_last_review'},
                    {'data': 'dev_next_review_date'},
                    {'data': 'dev_active_review_wc_no'},

                ],
                'createdRow': function (row, data, dataIndex) {
                    const $row = $(row);
                    $row.addClass('active-row');
                    $row.off('click');
                    $row.on('click', deviceInfo);
                }
            }
        );

        this.$yearSelect.on('change',function () {
            if (parseInt($(this).val()) === 0) {
                $monthSelect.val(0);
            }
        });
        this.$monthSelect.on('change', function () {
            if (parseInt($(this).val()) !== 0 && parseInt($yearSelect.val()) === 0) {
                $yearSelect.val(2020);
            }
        });

        this.$btnSearch.on('click', this.showDevices.bind(this));
    }

    showDevices = function () {
        console.log('showDevices');
        const dTable = this.deviceTable;
        const params = {
            departmentId: Number(this.$departmentSelect.val()),
            agrTypeId: Number(this.$agrTypeSelect.val()),
            technicianId: Number(this.$technicianSelect.val()),
            isSetGuaranteeDate: this.$isSetGuaranteeDateRadio.is(':checked') ? 1 : 0,
            isUnderWarranty: this.$isUnderWarrantyRadio.is(':checked') ? 1 : 0,
            calculatedReviewDateYear: Number(this.$yearSelect.val()),
            calculatedReviewDateMonth: Number(this.$monthSelect.val()),
        };
        $overlaySpinner.fadeIn(300);
        console.log(params);
        ax(
            params,
            '/bok/review/getDevicesToReview',
            function (devices) {
                console.log(devices);
                dTable.clear();
                dTable.rows.add(devices).draw();
                $overlaySpinner.fadeOut(300);
            }
        );
    };

    deviceInfo = function () {
        console.log('deviceInfo');

        const row = this;
        const $row = $(this);
        const devId = Number($row.attr('id'));

        const modalEl = document.querySelector('#modal-deviceInfo');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        const $modal = $('#modal-deviceInfo');

        const $modalHeaderText = $('#modal-header-text', $modal);
        const $modelString = $('div[title=model]', $modal);
        const $tab0 = $('#di-tab-0', $modal);
        const $tab1 = $('#di-tab-1', $modal);
        const $tab2 = $('#di-tab-2', $modal);
        const $tab3 = $('#di-tab-3', $modal);
        const $tab4 = $('#di-tab-4', $modal);
        const $tab5 = $('#di-tab-5', $modal);

        const $contactTable = $('#contactTable', $tab1);
        const contactTable = $contactTable.DataTable(
            {
                paging: false,
                autoWidth: false,
                searching: false,
                ordering: false,
                info: false,
                rowId: 'adr_id',
                columns: [
                    {'data': 'cont_type_name'},
                    {'data': 'cont_number'},
                    {'data': 'cont_description'},
                ],
                'createdRow': function (row, data, dataIndex) {
                    const $row = $(row);
                    $row.addClass('fw-bold');
                }

            }
        );

        const $rateTable = $('#rateTable', $tab3);
        const rateTable = $rateTable.DataTable(
            {
                paging: false,
                autoWidth: false,
                searching: false,
                ordering: false,
                info: false,
                rowId: 'dev_id',
                columns: [
                    {'data': 'service_lp'},
                    {'data': 'service_code'},
                    {'data': 'service_rate'},
                    {'data': 'service_free_copies_in_cnu'},
                    {'data': 'service_is_lump_sum'},
                    {'data': 'service_company_unit_name'},
                    {'data': 'service_notes'},
                ]
            }
        );

        const $counterTable = $('#counterTable', $tab4);
        const counterTable = $counterTable.DataTable(
            {
                paging: true,
                autoWidth: false,
                searching: true,
                ordering: true,
                info: false,
                rowId: 'dev_id',
                columns: [
                    {'data': 'counter_service_code'},
                    {'data': 'counter_value', className: 'text-end'},
                    {'data': 'counter_date_of_issue', className: 'text-center'},
                    {'data': 'counter_source'},
                    {'data': 'agr_no'},
                ],
                order: [[2, 'desc']],
            }
        );

        const $workCardTable = $('#workCardTable', $tab5);
        const workCardTable = $workCardTable.DataTable(
            {
                paging: true,
                autoWidth: false,
                searching: true,
                ordering: true,
                info: false,
                rowId: 'wc_id',
                columns: [
                    {'data': 'wc_no'},
                    {'data': 'wc_technician_name'},
                    {'data': 'wc_status_name'},
                    {'data': 'wc_register_date'},
                    {'data': 'wc_last_modification_date'},
                ],
                order: [[3, 'asc']],
                'createdRow': function (row, data, dataIndex) {
                    const $row = $(row);
                    $row.addClass('active-row');
                    $row.off('click');
                    $row.on('click', function () {
                        //console.log('showWc');
                        const $row = $(this);
                        const wcId = Number($row.attr('id'));
                        showWorkCard({wcId: wcId}, modal, null);
                    });
                },
            }
        );

        const modalClean = function () {
            console.log('modal hidden');
            modalEl.removeEventListener('hidden.bs.modal', modalClean);
            rateTable.destroy();
            counterTable.destroy();
            workCardTable.destroy();
            contactTable.destroy();
        };

        modalEl.addEventListener('hidden.bs.modal', modalClean);

        $overlaySpinner.fadeIn(300);
        ax(
            {devId: devId},
            '/bok/review/getDeviceData',
            function (res) {
                console.log(res);

                const d = res.data;
                const r = res.rates;
                const c = res.counters;
                const wc = res.wc;
                const ct = res.contacts;

                // ------ tab0
                let headerTex = '\xa0\xa0\xa0\xa0\xa0urządzenie:\xa0' + d.dev_model_name;
                headerTex += '\xa0\xa0\xa0\xa0\xa0nr ser.\xa0' + d.dev_serial_no;
                headerTex += '\xa0\xa0\xa0\xa0\xa0status:\xa0' + d.dev_status;
                $('.modal-title', $modalHeaderText).text(headerTex);

                $modelString.find('span').each(function () {
                        const $this = $(this);
                        $this.text(d[$this.attr('title')]);
                    }
                );
                $tab0.find('input[type=text]').each(function () {
                        const $this = $(this);
                        $this.val(d[$this.attr('name')]);
                    }
                );
                $tab0.find('textarea').each(function () {
                        const $this = $(this);
                        $this.val(d[$this.attr('name')]);
                    }
                );
                // ------ tab1
                contactTable.clear();
                contactTable.rows.add(ct).draw();
                $tab1.find('input[type=text]').each(function () {
                        const $this = $(this);
                        $this.val(d[$this.attr('name')]);
                    }
                );
                $tab1.find('textarea').each(function () {
                        const $this = $(this);
                        $this.val(d[$this.attr('name')]);
                    }
                );
                // ------ tab2
                $tab2.find('input[type=text]').each(function () {
                        const $this = $(this);
                        $this.val(d[$this.attr('name')]);
                    }
                );
                // ------ tab3
                for (let n in r) {
                    let item = r[n];
                    item.service_rate = digitForm(Number(item.service_rate).toFixed(2));
                    item.service_is_lump_sum = parseInt(item.service_is_lump_sum) === 1 ? 'tak' : 'nie';
                }
                rateTable.clear();
                rateTable.rows.add(r).draw();
                // ------ tab4
                for (let n in c) {
                    let item = c[n];
                    item.counter_value = Number(item.counter_value).toFixed(0);
                }
                counterTable.clear();
                counterTable.rows.add(c).draw();
                // ------ tab5
                workCardTable.clear();
                workCardTable.rows.add(wc).draw();

                // ----------------------------------------------
                $overlaySpinner.fadeOut(300);
                modal.show();
            }
        );

    }

}


// --------------------------------------------------------------
export {
    BillingIfNoCounter,
    ReplacementPartsKindOnAgreement,
    DeviceModelChange,
    ReplacementPartsKind,
    ExchangeTechnicianByTechnician,
    UpdateDevicesTechnician,
    UpdateInstallationAddress,
    DeviceMaintenanceService,
}






// // --------------------------------------------------------------
// $('#table1').dataTable({
//     destroy: true,
//     scrollX: true,
//     searching: true,
//     lengthChange: true,
//     pageLength: 5,
//     lengthMenu: [5, 10, 25, 50, 100],
//     paging: true,
//     pagingType: "simple_numbers" ,
//     info: true,
//     autoWidth: false,
//     columnDefs:[    { "defaultContent" : "", "searchable" : true, "className" : "text-left", "targets" : 0},
//         { "defaultContent" : "", "searchable" : true, "className" : "text-left", "targets" : 1},
//         { "defaultContent" : "", "searchable" : true, "className" : "text-left", "targets" : 2},
//         { "defaultContent" : "", "searchable" : true, "className" : "text-right", "targets" : 3},
//         { "defaultContent" : "", "searchable" : true, "className" : "text-left", "targets" : 4},
//         { "defaultContent" : "", "searchable" : true, "className" : "text-center", "targets" :5},
//         { "defaultContent" : "", "searchable" : true, "className" : "text-left", "targets" : 6},
//         { "defaultContent" : "", "searchable" : true, "className" : "text-left", "targets" : 7},
//         { "defaultContent" : "", "searchable" : true, "className" : "text-left", "targets" : 8}],
//     select:true ,
//     columns: [{"data":"id"},{"data":"name"},{"data":"lastName"},{"data":"age"},{"data":"birthDate"},{"data":"isVIP"},{"data":"gender"},{"data":"title"},{"data":"email"}]
// });

