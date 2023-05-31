<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Device extends Model
{
    use HasFactory;

    static function getDeviceBySerial($serialNo)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getDeviceBySerial] (:s)", ['s' => $serialNo]);
        return $res;
    }

    static function getDeviceModels($params)
    {
        $params = is_null($params) ? (object)['kind' => 0, 'type' => 0, 'producer' => 0, 'format' => 0,] : $params;
        $res = DB::connection('sqlsrv')->select("EXECUTE [dbo].[getDeviceModels] :k, :t, :p, :f", [
            'k' => $params->kind,
            't' => $params->type,
            'p' => $params->producer,
            'f' => $params->format
        ]);
        return $res;
    }

    static function getDeviceReplacementParts()
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getDeviceReplacementParts] ()");
        return $res;
    }

    static function getDeviceProducers()
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getDeviceProducers] () order by [dic_field_name]");
        return $res;
    }

    static function getDeviceTypes()
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getDeviceTypes] () order by [dic_field_name]");
        return $res;
    }

    static function getDeviceKinds()
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getDeviceKinds] () order by [dic_field_name]");
        return $res;
    }

    static function updateDeviceModel($data)
    {
        $res = DB::connection('sqlsrv')->select("
               EXECUTE [dbo].[updateDeviceModel] :devid, :devserial, :modelid",
               ['devid' => $data->devId, 'devserial' => $data->devSerial, 'modelid' => $data->modelId]
        );
        return $res;
    }

    static function updateDevicesFGBL($data)
    {
        $res = array();
        foreach ($data as $dev) {
            $r = DB::connection('sqlsrv')->select("
                    EXEC [dbo].[updateDevicesFGBL] @agrId = :aid , @itemId = :iid, @fgbl = :fgbl
                ", ['aid' => $dev->agrId, 'iid' => $dev->itemId, 'fgbl' => $dev->fgbl]
            );
            $res[] = $r[0];
        }
        return $res;
    }

    static function updateDevicesRPK($data)
    {
        $res = array();
        foreach ($data as $dev) {
            $r = DB::connection('sqlsrv')->select("
                    EXEC [dbo].[updateDevicesRPK] @agrId = :aid , @itemId = :iid, @rpk = :rpk, @rpkName = :rpkn
                ", ['aid' => $dev->agrId, 'iid' => $dev->itemId, 'rpk' => $dev->rpk, 'rpkn' => $dev->rpkName]
            );
            $res[] = $r[0];
        }
        return $res;
    }

}
