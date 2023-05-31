<?php

namespace App\Http\Controllers;

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
        //$deviceModels = DeviceController::getDeviceModels();
        $deviceModels = [];
        return view('bok.devices.index', [
            'deviceReplacementParts' => $deviceReplacementParts,
            'deviceProducers' => $deviceProducers,
            'deviceTypes' => $deviceTypes,
            'deviceKinds' => $deviceKinds,
            'deviceModels' => $deviceModels
        ]);
    }

    public function technicianIndex()
    {
        //
        return view('bok.technician.index');
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

    public function updateAgreementDevicesRPK(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::updateDevicesRPK($json->data);
        return Response::json($data);
    }

    // ----------- Devices ----------------------------
    public function getDeviceBySerial(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::getDeviceBySerial($json->serialNo);
        return Response::json($data);
    }

    public function getDeviceModels(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::getDeviceModels($json->data);
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



}
