<?php

namespace Modules\HRM\Database\Seeders;

use Illuminate\Database\Seeder;

class HrmStatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('hrm_status')->delete();
        
        \DB::table('hrm_status')->insert(array (
            0 => 
            array (
                'status' => 'Divorced',
                'list_index' => 1,
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'status' => 'Married',
                'list_index' => 1,
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'status' => 'Separated',
                'list_index' => 1,
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'status' => 'Single',
                'list_index' => 1,
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'status' => 'Widowed',
                'list_index' => 1,
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}