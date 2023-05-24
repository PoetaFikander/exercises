/**
 * obsługa modułu BOK
 *
 *
 **/

"use strict";

console.log('service BOK start');

import {ax} from "../functions.js";


// ------- BillingIfNoCounter = BINC

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

    save = function () {
        console.log('save');
        const data = {};
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
        console.log(data);
        ax(
            {data: data},
            '/bok/contracts/updateAgreementDevicesFGBL',
            function (data) {
                console.log(data);
            }
        )

    };

    showAgreementDevices = function () {
        console.log('showAgreementDevices');
        const deviceTable = this.deviceTable;
        const agrNo =  this.$agreementNoInput.val();

        this.$radioYes.prop('checked', false);
        this.$radioNo.prop('checked', false);

        ax(
            {agrNo: agrNo},
            '/bok/contracts/getAgreementId',
            function (data) {
                const agrId = parseInt(data.agrId);
                ax(
                    {agrId: agrId},
                    '/bok/contracts/getAgreementDevices',
                    function (data) {
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
                            item.action += (yes) ? ' checked>' : ' >';
                        }
                        deviceTable.clear();
                        deviceTable.rows.add(data).draw();
                    }
                );
            }
        );

    };

}

const binc = new BillingIfNoCounter('BillingIfNoCounterItem');

