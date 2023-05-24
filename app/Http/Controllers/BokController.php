<?php

namespace App\Http\Controllers;

use App\Repositories\AgreementRepository;
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
        return view('bok.contracts.index');
    }

    public function devicesIndex()
    {
        //
        return view('bok.devices.index');
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

    public function updateAgreementDevicesFGBL(Request $request){
        $json = jsonDecode($request->input('json'));
        $data = AgreementController::updateAgreementDevicesFGBL($json->data);
        return Response::json($data);
    }

}
