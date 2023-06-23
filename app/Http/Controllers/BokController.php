<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\Altum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BokController extends Controller
{
    //

    public function index()
    {
        //
        return view('bok.index');
    }

    public function contractsIndex()
    {
        //
        $deviceReplacementParts = DeviceController::getDeviceReplacementParts();
        return view('bok.contracts.index', ['deviceReplacementParts' => $deviceReplacementParts]);
    }

    public function devicesIndex()
    {
        //
        $deviceReplacementParts = DeviceController::getDeviceReplacementParts();
        $deviceProducers = DeviceController::getDeviceProducers();
        $deviceTypes = DeviceController::getDeviceTypes();
        $deviceKinds = DeviceController::getDeviceKinds();
        $departments = ToolController::getDepartments();
        $technicians = ToolController::getTechnicians();
        $models = DeviceController::getDeviceModels([]); // ['kind'=>619] typ nieokreślony

        $deviceModels = [];
        return view('bok.devices.index', [
            'deviceReplacementParts' => $deviceReplacementParts,
            'deviceProducers' => $deviceProducers,
            'deviceTypes' => $deviceTypes,
            'deviceKinds' => $deviceKinds,
            'deviceModels' => $deviceModels,
            'models' => $models,
            'departments' => $departments,
            'technicians' => $technicians
        ]);
    }

    public function technicianIndex()
    {
        //
        return view('bok.technician.index');
    }

    public function reviewIndex()
    {
        //
        $departments = ToolController::getDepartments();
        $technicians = ToolController::getTechnicians();
        $agrTypes = Agreement::getAgreementTypes();


        return view('bok.review.index', [
            'departments' => $departments,
            'technicians' => $technicians,
            'agrTypes' => $agrTypes,

        ]);
    }


    //---------------------------------------------------------------
//    public function getDeviceRates($devId)
//    {
//        $data = DeviceController::getDeviceRates($devId);
//        return $data;
//    }
//
//    public function getDeviceCounters($devId)
//    {
//        $data = DeviceController::getDeviceCounters($devId);
//        return $data;
//    }
//
//    public function getDeviceWorkCards($devId)
//    {
//        $p = ['devId'=>$devId];
//        $data = DeviceController::getDeviceWorkCards($p);
//        return $data;
//    }

    //---------------------------------------------------------------
    public function getDeviceData(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $res = (object)array();
        $devId = $json->devId;

        $data = DeviceController::getDeviceById($devId);
        $rates = DeviceController::getDeviceRates($devId);
        $counters = DeviceController::getDeviceCounters($devId);

        $p = ['devId'=>$devId];
        $wc = DeviceController::getDeviceWorkCards($p);

        $addrId = $data->dev_installation_address_id;
        $contacts = Altum::getAddressContacts($addrId);

        $res->data = $data;
        $res->rates = $rates;
        $res->counters = $counters;
        $res->wc = $wc;
        $res->contacts = $contacts;

        return Response::json($res);
    }


    // ===== AJAX =====

    // ----------- Agreements ----------------------------

    public function getAgreementId(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $agrId = AgreementController::getAgreementId($json->agrNo);
        $data = (object)$agrId;
        return Response::json($data);
    }

    public function getAgreementDevices(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = AgreementController::getAgreementDevices($json->agrId);
        return Response::json($data);
    }

    public function getDeviceReplacementParts(Request $request)
    {
        $data = DeviceController::getDeviceReplacementParts();
        return Response::json($data);
    }

    public function updateAgreementDevicesFGBL(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::updateDevicesFGBL($json->data);
        return Response::json($data);
    }

    // ----------- Devices ----------------------------

    public function updateDevicesRPK(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::updateDevicesRPK($json->data);
        return Response::json($data);
    }

    public function getDevices(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $parameters = array();
        foreach ($json as $key => $val) {
            $parameters[$key] = $val;
        }
        $data = DeviceController::getDevices($parameters);
        return Response::json($data);
    }

    public function getDevicesToReview(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $parameters = array();
        foreach ($json as $key => $val) {
            $parameters[$key] = $val;
        }
        $data = DeviceController::getDevicesToReview($parameters);
        return Response::json($data);
    }


    public function getDevicesWithoutInstallationAddress(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $parameters = array();
        foreach ($json as $key => $val) {
            $parameters[$key] = $val;
        }
        $data = DeviceController::getDevicesWithoutInstallationAddress($parameters);
        return Response::json($data);
    }


    public function getDeviceBySerial(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::getDeviceBySerial($json->serialNo);
        return Response::json($data);
    }

    public function getDeviceById(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::getDeviceById($json->devId);
        return Response::json($data);
    }

    public function getDeviceModels(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $parameters = array();
        foreach ($json as $key => $val) {
            $parameters[$key] = $val;
        }
        $data = DeviceController::getDeviceModels($parameters);
        return Response::json($data);
    }

    public function getDeviceProducers(Request $request)
    {
        $data = DeviceController::getDeviceProducers();
        return Response::json($data);
    }

    public function getDeviceTypes(Request $request)
    {
        $data = DeviceController::getDeviceTypes();
        return Response::json($data);
    }

    public function getDeviceKinds(Request $request)
    {
        $data = DeviceController::getDeviceKinds();
        return Response::json($data);
    }

    public function updateDeviceModel(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::updateDeviceModel($json->data);
        return Response::json($data);
    }

    public function updateDevicesTechnician(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::updateDevicesTechnician($json->data);
        return Response::json($data);
    }

    public function updateDevicesTechByTech(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::updateDevicesTechByTech($json->data);
        return Response::json($data);
    }

    public function getDeviceAddresses(Request $request)
    {
        $data = array();
        $json = jsonDecode($request->input('json'));
        $data['dev'] = DeviceController::getDeviceByAgrItemId($json->agrItemId);
        $custId = $data['dev']->cust_id;
        $data['addr'] = CustomerController::getCustomerAddresses($custId);
        return Response::json($data);
    }

    public function updateDeviceInstallationAddress(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::updateDeviceInstallationAddress($json->data);
        return Response::json($data);
    }


    public function getAgreementTypes()
    {
        $data = AgreementController::getAgreementTypes();
        return Response::json($data);
    }


}
