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
            $res = $profitRepository->getDeviceProfit($json->devId, $json->agrId, $json->dateFrom, $json->dateTo);
            $json->results = $res;
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }


    public function getDoc(ProfitRepository $profitRepository, Request $request){
        if ($request->ajax()) {
            $json = json_decode(htmlspecialchars_decode($request->input('json')));
            $json->test = $profitRepository->getDoc($json->docId, $json->docTypeId);
            $json->header = $profitRepository->getDocHeader($json->docId);
            $json->contents = $profitRepository->getDocContents($json->docId, 0);
            return Response::json($json);
        } else {
            //todo zrobić ogólną stronę błędów
            return view('auth.login');
        }
    }

}
