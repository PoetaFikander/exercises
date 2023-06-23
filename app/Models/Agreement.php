<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Agreement extends Model
{
    use HasFactory;

    static function getAgreementId($agrNo)
    {
        $res = DB::connection('sqlsrv')->select("
                SELECT [dbo].[getAgreementId] (:no) [agrId]
            ", ['no' => $agrNo]
        );
        return $res[0];
    }

    static function getAgreementDevices($agrId, $devStatus = 1)
    {
        $res = DB::connection('sqlsrv')->select("
                EXEC [dbo].[getAgreementDevicesList] @agrId = :id , @devStatus = :ds
            ", ['id' => $agrId, 'ds' => $devStatus]
        );
        return $res;
    }

    static function getAgreementTypes()
    {
        return DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getAgreementTypes] ()");
    }

}
