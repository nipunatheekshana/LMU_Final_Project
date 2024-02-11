<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsDataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings_data_types')->delete();
        
        \DB::table('settings_data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'data_type' => 'Text',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'data_type' => 'Date',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'data_type' => 'Time',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'data_type' => 'Currency',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'data_type' => 'Numeric',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}