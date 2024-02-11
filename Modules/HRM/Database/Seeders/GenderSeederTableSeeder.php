<?php

namespace Modules\HRM\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HRM\Entities\Gender;

class GenderSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $object= [
            ['id' => 1, 'gender'=>'Female'],
            ['id' => 2, 'gender'=>'Male'],
            ['id' => 3, 'gender'=>'Other'],
            ['id' => 4, 'gender'=>'Prefer not to say'],


        ];
        Gender::insert($object);
    }
}
