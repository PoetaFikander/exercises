<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AjaxController extends Controller
{
    //

    public function getWorkCard(Request $request)
    {
        $json = jsonDecode($request->input('json'));
        $data = DeviceController::getWorkCard($json->wcId);
        return Response::json($data);
    }


}
