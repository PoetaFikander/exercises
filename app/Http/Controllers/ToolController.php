<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    //

    static function getDepartments()
    {
        return Tool::getDepartments();
    }

    static function getTechnicians()
    {
        return Tool::getTechnicians();
    }


}
