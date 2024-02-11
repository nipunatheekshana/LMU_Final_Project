<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Entities\ItemGroup;
use Modules\Inventory\Entities\ItemGroups;

class ProductGroupsTableSeeder extends Seeder
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
            ['id' => 1, 'GroupName'=>'All Items Group','isGroup'=>true],
        ];
        ItemGroup::insert($object);
    }
}
