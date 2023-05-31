/**
 * obsługa modułu BOK
 *
 **/


"use strict";


console.log('service BOK start');

import {BillingIfNoCounter, ReplacementPartsKind, DeviceModelChange} from "./bok-functions.js";


// ---- odpalamy obsługę zakładki 'Fakturowanie gdy brak licznika'
const binc = new BillingIfNoCounter('accordionBokAgreements','BillingIfNoCounterItem');

// ---- odpalamy obsługę zakładki 'Rodzaj części zamiennych'
const rpk = new ReplacementPartsKind('accordionBokAgreements','ReplacementPartsKindItem');

// ---- odpalamy obsługę zakładki 'Zmiana modelu'
const dmc = new DeviceModelChange('accordionBokDevices','deviceModelChangeItem');
