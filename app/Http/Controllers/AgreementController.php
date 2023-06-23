<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Repositories\AgreementRepository;


// ===== AJAX =====

class AgreementController extends Controller
{

    static function getAgreementId($agrNo)
    {
        return Agreement::getAgreementId($agrNo);
    }

    static function getAgreementDevices($agrId)
    {
        return Agreement::getAgreementDevices($agrId);
    }

    static function getAgreementTypes()
    {
        return Agreement::getAgreementTypes();
    }

}
