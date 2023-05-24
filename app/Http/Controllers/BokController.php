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

    public function getAgreementId(AgreementRepository $agreementRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $agrId = $agreementRepository->getAgreementId($json->agrNo);
            $json->agrId = $agrId;
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }




}
