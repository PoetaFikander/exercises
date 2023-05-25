
import {ax, isObjectEmpty} from "../functions.js";

class BillingIfNoCounter {

    "use strict";

    constructor(itemId) {
        this.$item = $('#' + itemId);
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

        this.deviceTable = this.$deviceTable.DataTable(
            {
                paging: false,
                autoWidth: true,
                searching: false,
                ordering: false,
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
        this.getAgreementId(agrNo, this.getAgreementDevices, [this.deviceTable, this.refreshDeviceTable]);
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
                            if(fgbl === 'tak'){
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

    getAgreementId = function (agrNo, callback, params) {
        console.log('getAgreementId');
        ax(
            {agrNo: agrNo},
            '/bok/contracts/getAgreementId',
            function (data) {
                params.push(parseInt(data.agrId));
                callback.apply(this, params);
            }
        );
    };

    getAgreementDevices = function (table, callback, agrId) {
        console.log('getAgreementDevices');
        ax(
            {agrId: agrId},
            '/bok/contracts/getAgreementDevices',
            function (data) {
                if (table) callback(table, data);
            }
        );
    };

    refreshDeviceTable = function (table, data) {
        for (let n in data) {
            let item = data[n];
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
        table.clear();
        table.rows.add(data).draw();
    };

    showAgreementDevicesOLD = function () {
        console.log('showAgreementDevices');

        const deviceTable = this.deviceTable;
        const agrNo = this.$agreementNoInput.val();
        const getAgreementDevices = this.getAgreementDevices;

        this.$radioYes.prop('checked', false);
        this.$radioNo.prop('checked', false);

        ax(
            {agrNo: agrNo},
            '/bok/contracts/getAgreementId',
            function (data) {
                const agrId = parseInt(data.agrId);
                console.log(agrId);
                getAgreementDevices(agrId);

                // ax(
                //     {agrId: agrId},
                //     '/bok/contracts/getAgreementDevices',
                //     function (data) {
                //         for (let n in data) {
                //             let item = data[n];
                //             let yes = false;
                //
                //             let i = item.dev_billing_if_no_counter;
                //             switch (i) {
                //                 case '1':
                //                     item.dev_billing_if_no_counter = 'tak';
                //                     yes = true;
                //                     break;
                //                 case '2':
                //                     item.dev_billing_if_no_counter = 'nie';
                //                     break;
                //                 default:
                //                     item.dev_billing_if_no_counter = 'Nie wybrano';
                //             }
                //
                //             item.action = '<input class="form-check-input" type="checkbox"';
                //             item.action += ' data-itemid="' + item.agr_item_id + '"';
                //             item.action += ' data-agrid="' + item.agr_id + '"';
                //             item.action += (yes) ? ' checked>' : ' >';
                //         }
                //         deviceTable.clear();
                //         deviceTable.rows.add(data).draw();
                //     }
                // );


            }
        );

    };

}


export { BillingIfNoCounter }
