<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AltumDoc extends Model
{
    use HasFactory;

    static function getDocHeader($docId)
    {
        $res = DB::connection('sqlsrv')->select("SELECT * FROM [dbo].[getDocHeader] (:i)", ['i' => $docId]);
        return $res[0];
    }


}
