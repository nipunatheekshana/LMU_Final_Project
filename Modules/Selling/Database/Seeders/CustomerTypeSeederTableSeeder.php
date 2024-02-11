<?php

namespace Modules\Selling\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Selling\Entities\CustomerType;

class CustomerTypeSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $object= [
            ['id' => 1, 'customer_type'=>'Default'],
        ];
        CustomerType::insert($object);
    }
}
