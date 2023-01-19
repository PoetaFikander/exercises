<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
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
            ['name' => 'Gdańsk'],
            ['name' => 'Białystok'],
            ['name' => 'Bydgoszcz'],
            ['name' => 'Katowice'],
            ['name' => 'Kraków'],
            ['name' => 'Olsztyn'],
            ['name' => 'Łódź'],
            ['name' => 'Poznań'],
            ['name' => 'Rzeszów'],
            ['name' => 'Warszawa'],
            ['name' => 'Wrocław'],
        ];

        Department::insert($data);

    }
}
