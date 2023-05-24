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

    constructor(filtersFormId) {
        this.filtersFormId = filtersFormId;
        this.$filtersForm = $('#' + filtersFormId);
        this.$agreementNumberInput = $('input[name=agreementNumber]', this.$filtersForm);
        this.agreementNumber = null;
        //this.agreementNumber = this.$agreementNumberInput.val();
        this.$button = $('#button', this.$filtersForm);

        //this.$button.on('click', this.getAgreementNumber.bind(this));
        this.$button.on('click', this.getAgreementDevices.bind(this));
    }

    getAgreementDevices = function(){
        console.log('getAgreementDevices');
        const agrNo = this.$agreementNumberInput.val();
        ax(
            {agrNo:agrNo},
            '/bok/contracts/getAgreementId', function (data) {
                console.log(data);
            }
        );

    };

    getAgreementNumber = function () {
        console.log(this.$agreementNumberInput.val());
        //console.log(this);

    };

}

const binc = new BillingIfNoCounter('BINC-filters');

