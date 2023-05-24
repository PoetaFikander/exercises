<?php

use Carbon\Carbon;

if (!function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}

if (!function_exists('jsonDecode')) {
    function jsonDecode($json)
    {
        return json_decode(htmlspecialchars_decode($json));
    }
}



