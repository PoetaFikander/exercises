<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;

    static function getCustomerAddresses($customerId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getCustomerAddresses] (:i)", ['i' => $customerId]);
        return $res;
    }


}
