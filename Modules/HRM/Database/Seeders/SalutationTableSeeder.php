<?php

namespace Modules\HRM\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HRM\Entities\Salutation;

class SalutationTableSeeder extends Seeder
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
            ['id' => 1, 'salutation'=>'Dr.'],
            ['id' => 2, 'salutation'=>'Eng.'],
            ['id' => 3, 'salutation'=>'Madam'],
            ['id' => 4, 'salutation'=>'Master'],
            ['id' => 5, 'salutation'=>'Miss.'],
            ['id' => 6, 'salutation'=>'Mr.'],
            ['id' => 7, 'salutation'=>'Mrs.'],
            ['id' => 8, 'salutation'=>'Ms.'],
            ['id' => 9, 'salutation'=>'Mx.'],
            ['id' => 10, 'salutation'=>'Prof.'],
            ['id' => 11, 'salutation'=>'Rev.'],
            ['id' => 12, 'salutation'=>'Ven.'],
        ];
        Salutation::insert($object);
    }
}
