<?php

namespace Modules\Sf\Database\Seeders;

use Illuminate\Database\Seeder;

class SfCuttingTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sf_cutting_type')->delete();
        
        \DB::table('sf_cutting_type')->insert(array (
            0 => 
            array (
                'id' => 1,
                'CutTypeCode' => 'CTC',
                'CutTypeName' => 'Center Cut',
                'list_index' => 1,
                'created_by' => '1',
                'modified_by' => '1',
                'enabled' => 1,
                'created_at' => '2022-07-06 08:08:20',
                'updated_at' => '2022-07-06 08:13:06',
            ),
            1 => 
            array (
                'id' => 2,
                'CutTypeCode' => 'CUB',
                'CutTypeName' => 'Cube',
                'list_index' => 2,
                'created_by' => '1',
                'modified_by' => '1',
                'enabled' => 1,
                'created_at' => '2022-07-06 08:08:35',
                'updated_at' => '2022-07-06 08:09:36',
            ),
            2 => 
            array (
                'id' => 3,
                'CutTypeCode' => 'FIL',
                'CutTypeName' => 'Fillet',
                'list_index' => 3,
                'created_by' => '1',
                'modified_by' => '1',
                'enabled' => 1,
                'created_at' => '2022-07-06 08:09:45',
                'updated_at' => '2022-07-06 08:10:47',
            ),
            3 => 
            array (
                'id' => 4,
                'CutTypeCode' => 'G&G',
                'CutTypeName' => 'Gilled & Gutted',
                'list_index' => 4,
                'created_by' => '1',
                'modified_by' => '1',
                'enabled' => 1,
                'created_at' => '2022-07-06 08:10:37',
                'updated_at' => '2022-07-06 08:13:18',
            ),
            4 => 
            array (
                'id' => 5,
                'CutTypeCode' => 'H&G',
                'CutTypeName' => 'Head & Gutted',
                'list_index' => 5,
                'created_by' => '1',
                'modified_by' => '1',
                'enabled' => 1,
                'created_at' => '2022-07-06 08:11:30',
                'updated_at' => '2022-07-06 08:13:28',
            ),
            5 => 
            array (
                'id' => 6,
                'CutTypeCode' => 'LON',
                'CutTypeName' => 'Loin',
                'list_index' => 6,
                'created_by' => '1',
                'modified_by' => '1',
                'enabled' => 1,
                'created_at' => '2022-07-06 08:12:03',
                'updated_at' => '2022-07-06 08:12:45',
            ),
            6 => 
            array (
                'id' => 7,
                'CutTypeCode' => 'STK',
                'CutTypeName' => 'Steak',
                'list_index' => 7,
                'created_by' => '1',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => '2022-07-06 08:12:30',
                'updated_at' => '2022-07-06 08:12:30',
            ),
        ));
        
        
    }
}