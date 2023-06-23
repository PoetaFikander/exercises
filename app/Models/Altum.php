<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Altum extends Model
{
    use HasFactory;

    static function getAddressContacts($addrId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getAddressContacts] (:i)", ['i' => $addrId]);
        return $res;
    }

}
