<?php

namespace Modules\Sf\Database\Seeders;

use Illuminate\Database\Seeder;

class SfCatchMethodTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sf_catch_method')->delete();
        
        \DB::table('sf_catch_method')->insert(array (
            0 => 
            array (
                'id' => 1,
                'CatchMethodCode' => 'H&L',
                'CatchMethodName' => 'Hook and Line',
                'list_index' => 1,
                'created_by' => '2',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => '2022-06-30 06:12:32',
                'updated_at' => '2022-06-30 06:12:32',
            ),
            1 => 
            array (
                'id' => 2,
                'CatchMethodCode' => 'NET',
                'CatchMethodName' => 'Netting',
                'list_index' => 2,
                'created_by' => '2',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => '2022-06-30 06:13:25',
                'updated_at' => '2022-06-30 06:13:25',
            ),
        ));
        
        
    }
}