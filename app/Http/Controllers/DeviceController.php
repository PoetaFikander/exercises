<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    //

    static function getDevices($parameters)
    {
        return Device::getDevices($parameters);
    }

    static function getDevicesWithoutInstallationAddress($parameters)
    {
        return Device::getDevicesWithoutInstallationAddress($parameters);
    }

    static function getDeviceBySerial($serialNo)
    {
        return Device::getDeviceBySerial($serialNo);
    }

    static function getDeviceByAgrItemId($agrItemId)
    {
        return Device::getDeviceByAgrItemId($agrItemId);
    }

    static function getDeviceModels($parameters)
    {
        return Device::getDeviceModels($parameters);
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

    static function updateDevicesTechnician($data)
    {
        return Device::updateDevicesTechnician($data);
    }

    static function updateDevicesTechByTech($data)
    {
        return Device::updateDevicesTechByTech($data);
    }

    static function updateDeviceInstallationAddress($data)
    {
        return Device::updateDeviceInstallationAddress($data);
    }

}
