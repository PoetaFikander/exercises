/**
 * obsługa modułu BOK
 *
 **/


"use strict";


console.log('service BOK start');

import {
    BillingIfNoCounter,
    ReplacementPartsKindOnAgreement,
    DeviceModelChange,
    ReplacementPartsKind,
    ExchangeTechnicianByTechnician,
    UpdateDevicesTechnician,
    UpdateInstallationAddress,
} from "./bok-functions.js";


// ---- odpalamy obsługę zakładki 'Fakturowanie gdy brak licznika'
const binc = new BillingIfNoCounter('accordionBokAgreements', 'BillingIfNoCounterItem');

// ---- odpalamy obsługę zakładki 'Rodzaj części zamiennych' na umowach
const rpkoa = new ReplacementPartsKindOnAgreement('accordionBokAgreements', 'ReplacementPartsKindItem');

// ---- odpalamy obsługę zakładki 'Zmiana modelu'
const dmc = new DeviceModelChange('accordionBokDevices', 'deviceModelChangeItem');

// ---- odpalamy obsługę zakładki 'Rodzaj części zamiennych' ogólnie
const rpk = new ReplacementPartsKind('accordionBokDevices', 'ReplacementPartsKindItem');

// ===== odpalamy obsługę zakładki 'Podmiana techników obsługujących urządzenia' =====
const etbt = new ExchangeTechnicianByTechnician('accordionBokDevices','exchangeTechnicianByTechnicianItem');

// ===== odpalamy obsługę zakładki 'Zmiana technika obsługującego urządzenie' =====
const udt = new UpdateDevicesTechnician('accordionBokDevices','changeDeviceTechnicianItem');

// ===== obsługa zakładki 'Brak adresu instalacji' =====
const uia = new UpdateInstallationAddress('accordionBokDevices','noInstallationAddressItem');
