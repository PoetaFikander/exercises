<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tool extends Model
{
    use HasFactory;


    static function getDepartments()
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[departments]");
        return $res;
    }

    static function getTechnicians()
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getTechnicians] () order by [dic_field_name]");
        return $res;
    }


}
