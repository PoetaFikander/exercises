<?php

namespace App\Http\Controllers;

use App\Models\Profit;
use Illuminate\Support\Facades\Response;
use App\Repositories\ProfitRepository;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    public function index()
    {
        //
        return view('profits.index');
    }


    public function showDevicesList(ProfitRepository $profitRepository, $devices = [])
    {
        // tymczas, prawdopodobnie do usunięcia
        if (!count($devices)) {
            $d = $profitRepository->getDevicesList();
            $devices = $d['devices'];
        }
        return view('profits.devices.list', ['devices' => $devices]);
    }


    public function getDevicesList(ProfitRepository $profitRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $parameters = array();
            foreach ($json as $key => $val) {
                $parameters[$key] = $val;
            }
            $results = $profitRepository->getDevicesList($parameters);
            $json->parameters = $results['p'];
            $json->devices = $results['devices'];
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }


    public function showDeviceProfit(ProfitRepository $profitRepository, $devId, $agrId)
    {
        //var_dump($agrId);
        $device = $profitRepository->getDeviceData($devId, $agrId);
        return view('profits.devices.profit', ['device' => $device, 'agrId' => $agrId]);
    }


    public function getDeviceProfit(ProfitRepository $profitRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $res = $profitRepository->getDeviceProfit($json->devid, $json->agrid, $json->dateFrom, $json->dateTo);
            $json->results = $res;
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }


    public function getDeviceProfitCalc(ProfitRepository $profitRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            //dd($json);
            $res = $profitRepository->getDeviceProfitCalc($json->devid, $json->agrid, $json->dateFrom, $json->dateTo);
            $json->results = $res;
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }


    public function showContractsList(ProfitRepository $profitRepository)
    {
        // ----
        $departments = $profitRepository->getDepartments();
        return view('profits.contracts.list', ['departments' => $departments]);
    }


    public function getContractsList(ProfitRepository $profitRepository, Request $request)
    {
        // ----
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $parameters = array();
            foreach ($json as $key => $val) {
                $parameters[$key] = $val;
            }
            $results = $profitRepository->getContractsList($parameters);
            $json->parameters = $results['p'];
            $json->contracts = $results['contracts'];
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }


    public function showContractProfit(ProfitRepository $profitRepository, $agrId)
    {
        $c = $profitRepository->getContractData($agrId);
        $contract = $c[0];
        $dev = $profitRepository->getContractDevices($agrId);
        //dd($contract);
        return view('profits.contracts.profit', ['contract' => $contract, 'devices' => $dev, 'agrId' => $agrId]);
    }


    public function getContractDevices(ProfitRepository $profitRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $dev = $profitRepository->getContractDevices($json->agrid);
            $json->dev = $dev;
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }


    public function getContractProfit(ProfitRepository $profitRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $res = $profitRepository->getContractProfit($json->agrid, $json->dateFrom, $json->dateTo, $json->counterId);
            $json->results = $res;
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }


    public function setContractCounter(ProfitRepository $profitRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $json->setCount = $profitRepository->setAgreementCounter($json->counterId, $json->devQuantity);
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }


    public function getContractCounter(ProfitRepository $profitRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $json->getCount = $profitRepository->getAgreementCounter($json->counterId);
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }


    public function updateContractCounter(ProfitRepository $profitRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $json->upCount = $profitRepository->updateAgreementCounter($json->counterId, $json->counter, $json->devQuantity, $json->break);
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }

    public function breakContractCounter(ProfitRepository $profitRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $json->brCount = $profitRepository->breakAgreementCounter($json->counterId);
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }


    public function getDoc(ProfitRepository $profitRepository, Request $request)
    {
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $doc = $profitRepository->getDoc($json->docId, $json->docTypeId);
            //dd($doc);
            $json->doc = $doc;
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }

}
