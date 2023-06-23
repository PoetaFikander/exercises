<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Device extends Model
{
    use HasFactory;



    static function getDevices($parameters = [])
    {
        $p = $parameters;
        if (!count($p)) {
            $p = [
                'departmentId' => 0,
                'technicianId' => 0,
                'deviceKindId' => 0,
                'zipCode' => '',

                'agrItemId' => 0,
                'devId' => 0,
                'serialNo' => '',
                'addressId' => null,

                'modelId' => 0,

                'agrItemIsActive' => 1,
                'agrItemIsDeleted' => 0,
                'deviceIsDeleted' => 0,

            ];
        } else {
            $p['departmentId'] = array_key_exists('departmentId', $p) ? $p['departmentId'] : 0;
            $p['technicianId'] = array_key_exists('technicianId', $p) ? $p['technicianId'] : 0;
            $p['deviceKindId'] = array_key_exists('deviceKindId', $p) ? $p['deviceKindId'] : 0;
            $p['zipCode'] = array_key_exists('zipCode', $p) ? $p['zipCode'] : '';

            $p['agrItemId'] = array_key_exists('agrItemId', $p) ? $p['agrItemId'] : 0;
            $p['devId'] = array_key_exists('devId', $p) ? $p['devId'] : 0;
            $p['serialNo'] = array_key_exists('serialNo', $p) ? $p['serialNo'] : '';
            $p['addressId'] = array_key_exists('addressId', $p) ? $p['devId'] : null;

            $p['modelId'] = array_key_exists('modelId', $p) ? $p['modelId'] : 0;

            $p['agrItemIsActive'] = array_key_exists('agrItemIsActive', $p) ? $p['agrItemIsActive'] : 1;
            $p['agrItemIsDeleted'] = array_key_exists('agrItemIsDeleted', $p) ? $p['agrItemIsDeleted'] : 0;
            $p['deviceIsDeleted'] = array_key_exists('deviceIsDeleted', $p) ? $p['deviceIsDeleted'] : 0;
        }
        //dd($p);
        $res = DB::connection('sqlsrv')->select(
            "EXECUTE [dbo].[getDevicesListV2] :d, :t, :k, :z, :aii, :di, :sn, :ai, :mi, :aiia, :aiid, :did",
            [
                'd' => $p['departmentId'],
                't' => $p['technicianId'],
                'k' => $p['deviceKindId'],
                'z' => $p['zipCode'],

                'aii' => $p['agrItemId'],
                'di' => $p['devId'],
                'sn' => $p['serialNo'],
                'ai' => $p['addressId'],

                'mi' => $p['modelId'],

                'aiia' => $p['agrItemIsActive'],
                'aiid' => $p['agrItemIsDeleted'],
                'did' => $p['deviceIsDeleted'],
            ]
        );
        return $res;
    }

    static function getDevicesToReview($parameters = [])
    {
        $p = $parameters;
        if (!count($p)) {
            $p = [
                'departmentId' => 0,
                'technicianId' => 0,
                'isSetGuaranteeDate' => 1,
                'agrTypeId' => 0,
                'isUnderWarranty' => 1,
                'calculatedReviewDateYear' => 0,
                'calculatedReviewDateMonth' => 0,
            ];
        } else {
            $p['departmentId'] = array_key_exists('departmentId', $p) ? $p['departmentId'] : 0;
            $p['technicianId'] = array_key_exists('technicianId', $p) ? $p['technicianId'] : 0;
            $p['isSetGuaranteeDate'] = array_key_exists('isSetGuaranteeDate', $p) ? $p['isSetGuaranteeDate'] : 1;
            $p['agrTypeId'] = array_key_exists('agrTypeId', $p) ? $p['agrTypeId'] : 0;
            $p['isUnderWarranty'] = array_key_exists('isUnderWarranty', $p) ? $p['isUnderWarranty'] : 1;
            $p['calculatedReviewDateYear'] = array_key_exists('calculatedReviewDateYear', $p) ? $p['calculatedReviewDateYear'] : 0;
            $p['calculatedReviewDateMonth'] = array_key_exists('calculatedReviewDateMonth', $p) ? $p['calculatedReviewDateMonth'] : 0;
        }

        $res = DB::connection('sqlsrv')->select(
            "EXECUTE [dbo].[getDevicesToReview] :d, :t, :i, :a, :iu, :y, :m",
            [
                'd' => $p['departmentId'],
                't' => $p['technicianId'],
                'i' => $p['isSetGuaranteeDate'],
                'a' => $p['agrTypeId'],
                'iu' => $p['isUnderWarranty'],
                'y' => $p['calculatedReviewDateYear'],
                'm' => $p['calculatedReviewDateMonth'],
            ]
        );
        return $res;
    }

    static function getDevicesWithoutInstallationAddress($parameters = [])
    {
        $p = $parameters;
        if (!count($p)) {
            $p = [
                'departmentId' => 0,
                'agrKindId' => 0,
                'problemId' => 0,
            ];
        } else {
            $p['departmentId'] = array_key_exists('departmentId', $p) ? $p['departmentId'] : 0;
            $p['agrKindId'] = array_key_exists('agrKindId', $p) ? $p['agrKindId'] : 0;
            $p['problemId'] = array_key_exists('problemId', $p) ? $p['problemId'] : 0;
        }
        $res = DB::connection('sqlsrv')->select(
            "EXECUTE [dbo].[getDevicesWithoutInstallationAddress] :d, :a, :p",
            [
                'd' => $p['departmentId'],
                'a' => $p['agrKindId'],
                'p' => $p['problemId'],
            ]
        );
        return $res;
    }

    static function getDeviceWorkCards($parameters = [])
    {
        $p = $parameters;
        if (!count($p)) {
            $p = [
                'devId' => 0,
                'customerId' => 0,
                'stateId' => 0,
                'serviceId' => 0,
            ];
        } else {
            $p['devId'] = array_key_exists('devId', $p) ? $p['devId'] : 0;
            $p['customerId'] = array_key_exists('customerId', $p) ? $p['customerId'] : 0;
            $p['stateId'] = array_key_exists('stateId', $p) ? $p['stateId'] : 0;
            $p['serviceId'] = array_key_exists('serviceId', $p) ? $p['serviceId'] : 0;
        }
        $res = DB::connection('sqlsrv')->select(
            "EXECUTE [dbo].[getDeviceWorkCards] :d, :c, :s, :p",
            [
                'd' => $p['devId'],
                'c' => $p['customerId'],
                's' => $p['stateId'],
                'p' => $p['serviceId'],
            ]
        );
        return $res;
    }

    static function getDeviceBySerial($serialNo)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getDeviceBySerial] (:s)", ['s' => $serialNo]);
        return $res;
    }

    static function getDeviceByAgrItemId($agrItemId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getDeviceByAgrItemId] (:i)", ['i' => $agrItemId]);
        return $res[0];
    }

    static function getDeviceById($devId)
    {
        $res = DB::connection('sqlsrv')->select("EXECUTE [dbo].[getDeviceById] :i", ['i' => $devId]);
        return $res[0];
    }

    static function getDeviceRates($devId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getDeviceRates] (:i)", ['i' => $devId]);
        return $res;
    }

    static function getDeviceCounters($devId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getDeviceCounters] (:i)", ['i' => $devId]);
        return $res;
    }

    static function getDeviceModels($parameters = [])
    {
        $p = $parameters;
        if (!count($p)) {
            $p = [
                'kind' => 0,
                'type' => 0,
                'producer' => 0,
                'format' => 0,
            ];
        } else {
            $p['kind'] = array_key_exists('kind', $p) ? $p['kind'] : 0;
            $p['type'] = array_key_exists('type', $p) ? $p['type'] : 0;
            $p['producer'] = array_key_exists('producer', $p) ? $p['producer'] : 0;
            $p['format'] = array_key_exists('format', $p) ? $p['format'] : 0;
        }

        //dd($p);

        $res = DB::connection('sqlsrv')->select("EXECUTE [dbo].[getDeviceModels] :k, :t, :p, :f", [
            'k' => $p['kind'],
            't' => $p['type'],
            'p' => $p['producer'],
            'f' => $p['format'],
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
        return $res[0];
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

    static function updateDevicesTechnician($data)
    {
        $res = array();
        foreach ($data as $dev) {
            $r = DB::connection('sqlsrv')->select("
                    EXECUTE [dbo].[updateDevicesTechnician] :aiid, :iid, :t",
                ['aiid' => $dev->agrItemId, 'iid' => $dev->itemId, 't' => $dev->technicianNew]
            );
            $res[] = $r[0];
        }
        return $res;
    }

    static function updateDevicesTechByTech($data)
    {
        $res = DB::connection('sqlsrv')->select("
               EXECUTE [dbo].[updateDevicesTechByTech] :old, :new",
            ['old' => $data->technicianOld, 'new' => $data->technicianNew]
        );
        return $res;
    }

    static function updateDeviceInstallationAddress($data)
    {
        $res = DB::connection('sqlsrv')->select("
               EXECUTE [dbo].[updateDeviceInstallationAddress] :agritemid, :addrdataid",
            ['agritemid' => $data->agrItemId, 'addrdataid' => $data->addrDataId]
        );
        return $res[0];
    }



    static function getWorkCardHeader($wcId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getWorkCardHeader] (:i)", ['i' => $wcId]);
        return $res[0];
    }

    static function getWorkCardActions($wcId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getWorkCardActions] (:i)", ['i' => $wcId]);
        return $res;
    }

    static function getWorkCardMaterials($wcId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getWorkCardMaterials] (:i)", ['i' => $wcId]);
        return $res;
    }

    static function getWorkCardServices($wcId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getWorkCardServices] (:i)", ['i' => $wcId]);
        return $res;
    }

    static function getWorkCardDocs($wcId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getWorkCardDocs] (:i)", ['i' => $wcId]);
        return $res;
    }



}
