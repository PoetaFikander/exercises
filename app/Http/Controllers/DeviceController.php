<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    //
    static function getDeviceBySerial($serialNo)
    {
        return Device::getDeviceBySerial($serialNo);
    }

    static function getDeviceModels($params = null){
        return Device::getDeviceModels($params);
    }

    static function getDeviceReplacementParts()
    {
        return Device::getDeviceReplacementParts();
    }

    static function getDeviceProducers()
    {
        return Device::getDeviceProducers();
    }

    static function getDeviceTypes()
    {
        return Device::getDeviceTypes();
    }

    static function getDeviceKinds()
    {
        return Device::getDeviceKinds();
    }

    static function updateDevicesFGBL($data)
    {
        return Device::updateDevicesFGBL($data);
    }

    static function updateDevicesRPK($data)
    {
        return Device::updateDevicesRPK($data);
    }

    static function updateDeviceModel($data)
    {
        return Device::updateDeviceModel($data);
    }

}
