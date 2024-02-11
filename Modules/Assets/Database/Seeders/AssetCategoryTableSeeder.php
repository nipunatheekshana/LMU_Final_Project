<?php

namespace Modules\Assets\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Assets\Entities\AssetCategory;

class AssetCategoryTableSeeder extends Seeder
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
            [
            'id' => 1, 
            'company' => 1, 
            'asset_category_name'=>'Default',
            'category_short_code'=>'DFL',
            'enabled'=>1
            ],
        ];
        AssetCategory::insert($object);
    }
}
