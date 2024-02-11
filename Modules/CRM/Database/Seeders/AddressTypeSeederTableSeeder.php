<?php

namespace Modules\CRM\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CRM\Entities\AddressType;

class AddressTypeSeederTableSeeder extends Seeder
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
            ['id' => 1, 'AddressType'=>'Billing'],
            ['id' => 2, 'AddressType'=>'Shipping'],
            ['id' => 3, 'AddressType'=>'Office'],
            ['id' => 4, 'AddressType'=>'Personal'],
            ['id' => 5, 'AddressType'=>'Plant'],
            ['id' => 6, 'AddressType'=>'Postal'],
            ['id' => 7, 'AddressType'=>'Shop'],
            ['id' => 8, 'AddressType'=>'Subsidiary'],
            ['id' => 9, 'AddressType'=>'Werehouse'],
            ['id' => 10, 'AddressType'=>'Current'],
            ['id' => 11, 'AddressType'=>'Permanent'],
            ['id' => 12, 'AddressType'=>'Other'],
        ];
        AddressType::insert($object);
    }
}
