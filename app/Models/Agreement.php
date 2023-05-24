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
                SELECT [dbo].[GetAgreementId] (:no) [agrId]
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

    static function updateAgreementDevicesFGBL($data)
    {
        $res = array();
        foreach ($data as $dev) {
            $r = DB::connection('sqlsrv')->select("
                    EXEC [dbo].[updateAgreementDevicesFGBL] @agrId = :aid , @itemId = :iid, @fgbl = :fgbl
                ", ['aid' => $dev->agrId, 'iid' => $dev->itemId, 'fgbl'=>$dev->fgbl]
            );
            $res[] = (object)[
                'agr_id' => $dev->agrId,
                'agr_item_id' => $dev->itemId,
                'fgbl' => $dev->fgbl,
                'result' => $r
            ];
        }
        return $res;
    }


}
