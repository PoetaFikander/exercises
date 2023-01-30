<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            ['name' => 'restApi_baseUrl', 'value'=>'http://192.168.1.13:3000'],
            ['name' => 'restApi_customers_list', 'value'=>'/api/customers/list'],
            ['name' => 'restApi_customers_getbyid', 'value'=>'/api/customers/getbyid/'],
            ['name' => 'restApi_customers_getbycode', 'value'=>'/api/customers/getbycode/'],
            ['name' => 'restApi_customers_getemptymodel', 'value'=>'/api/customers/getemptymodel'],
            ['name' => 'restApi_customers_getdivisions', 'value'=>'/api/customers/getdivisions'],
            ['name' => 'restApi_customers_getdivisiongroups', 'value'=>'/api/customers/getdivisiongroups?DivisionId='],
            ['name' => 'restApi_customers_save', 'value'=>'/api/customers/save'],
            ['name' => 'restApi_articles_getbyid', 'value'=>'/api/articles/getbyid/'],
        ];

        Setting::insert($data);

    }
}
