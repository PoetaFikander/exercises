<?php

namespace App\Traits;

use App\Models\Setting;

trait GlobalTrait {

    //
    public function getAllSettings(){
        //
        $settings = Setting::all();
        return $settings;
    }
}
