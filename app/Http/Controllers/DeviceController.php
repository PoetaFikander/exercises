<?php

namespace App\Http\Controllers;

use App\Models\AltumDoc;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    //

    static function getDevices($parameters)
    {
        return Device::getDevices($parameters);
    }

    static function getDevicesToReview($parameters)
    {
        return Device::getDevicesToReview($parameters);
    }

    static function getDevicesWithoutInstallationAddress($parameters)
    {
        return Device::getDevicesWithoutInstallationAddress($parameters);
    }

    static function getDeviceWorkCards($parameters)
    {
        return Device::getDeviceWorkCards($parameters);
    }

    static function getDeviceBySerial($serialNo)
    {
        return Device::getDeviceBySerial($serialNo);
    }

    static function getDeviceByAgrItemId($agrItemId)
    {
        return Device::getDeviceByAgrItemId($agrItemId);
    }

    static function getDeviceById($devId)
    {
        return Device::getDeviceById($devId);
    }

    static function getDeviceRates($devId)
    {
        return Device::getDeviceRates($devId);
    }

    static function getDeviceCounters($devId)
    {
        return Device::getDeviceCounters($devId);
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



    static function getWorkCard($wcId)
    {
        $results = array();
        $results['header'] = Device::getWorkCardHeader($wcId);
        $results['actions'] = Device::getWorkCardActions($wcId);
        $results['materials'] = Device::getWorkCardMaterials($wcId);
        $results['services'] = Device::getWorkCardServices($wcId);
        $documents = array();
        $wcDocs = Device::getWorkCardDocs($wcId);
        foreach ($wcDocs as $d) {
            if ((int)$d->doc_id > 0) {
                $h = AltumDoc::getDocHeader($d->doc_id);
                $documents[] = $h;
            }
        }
        $results['documents'] = $documents;
        return $results;
    }


}
