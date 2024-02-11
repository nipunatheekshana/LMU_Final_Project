<?php

namespace Modules\Sf\Database\Seeders;

use Illuminate\Database\Seeder;

class SfCatchAreaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sf_catch_area')->delete();
        
        \DB::table('sf_catch_area')->insert(array (
            0 => 
            array (
                'id' => 1,
                'AreaCode' => 'AR1',
                'AreaName' => 'Area 01',
                'list_index' => 1,
                'created_by' => '1',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => '2022-07-06 07:23:40',
                'updated_at' => '2022-07-06 07:23:40',
            ),
            1 => 
            array (
                'id' => 2,
                'AreaCode' => 'AR2',
                'AreaName' => 'Area 02',
                'list_index' => 2,
                'created_by' => '1',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => '2022-07-06 07:24:17',
                'updated_at' => '2022-07-06 07:24:17',
            ),
            2 => 
            array (
                'id' => 3,
                'AreaCode' => 'AR3',
                'AreaName' => 'Area 03',
                'list_index' => 3,
                'created_by' => '1',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => '2022-07-06 08:47:43',
                'updated_at' => '2022-07-06 08:47:43',
            ),
        ));
        
        
    }
}