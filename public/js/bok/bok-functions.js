import {ax, isObjectEmpty} from "../functions.js";


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

// ===== obsługa zakładki 'Rodzaj części zamiennych' =====
class ReplacementPartsKind {

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
                dom: '<"top">rt<"bottom"flp>' // przeniesienie Search na dół
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
                '/bok/contracts/updateAgreementDevicesRPK',
                function (data) {
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

class DeviceModelChange {
    "use strict";

    constructor(accordionId, itemId) {
        this.$accordion = $('#' + accordionId);
        this.$item = $('#' + itemId, this.$accordion);
        this.$serialNoInput = $('input[name=serialNo]', this.$item);
        this.$devNameInput = $('input[name=devName]', this.$item);
        this.$kindInput = $('select[name=kind]', this.$item);
        this.$typeInput = $('select[name=type]', this.$item);
        this.$producerInput = $('select[name=producer]', this.$item);
        this.$modelInput = $('select[name=model]', this.$item);
        this.$btnSearch = $('#btn-search', this.$item);
        this.$btnSearchModel = $('#btn-search-model', this.$item);
        this.$btnSave = $('#btn-save', this.$item);
        //

        this.$btnSearch.on('click', this.showDevice.bind(this));
        this.$btnSearchModel.on('click', this.getDeviceModels.bind(this));
        this.$btnSave.on('click', this.save.bind(this));
    }

    showDevice = function () {
        console.log('showDevice');
        const serialNo = this.$serialNoInput.val();
        getDeviceBySerial(serialNo, this.$devNameInput, this.refreshDevice);
    };

    getDeviceModels = function () {
        console.log('getDeviceModels');
        const $select = this.$modelInput;
        const o = {
            data: {
                kind: parseInt(this.$kindInput.val()),
                type: parseInt(this.$typeInput.val()),
                producer: parseInt(this.$producerInput.val()),
                format: 0
            }
        };
        ax(
            o,
            '/bok/devices/getDeviceModels',
            function (data) {
                //console.log(data);
                $select.html('');
                for (let n in data) {
                    let item = data[n];
                    $select.append('<option value="' + item.dic_field_id + '">' + item.dic_field_name + '</option>');
                }
            }
        );
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
                            console.log(data);
                        }
                    );
                }
            })
        }

    }

}

// --------------------------------------------------------------
export {BillingIfNoCounter, ReplacementPartsKind, DeviceModelChange}
