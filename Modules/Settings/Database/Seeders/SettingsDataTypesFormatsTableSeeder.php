<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsDataTypesFormatsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings_data_types_formats')->delete();
        
        \DB::table('settings_data_types_formats')->insert(array (
            0 => 
            array (
                'id' => 1,
                'data_type_id' => 2,
                'format' => 'YY-MM-DD',
                'sample_data' => '22-05-13',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'data_type_id' => 2,
                'format' => 'YYYY-MM-DD',
                'sample_data' => '2022-05-13',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'data_type_id' => 2,
                'format' => 'DD-MM-YYYY',
                'sample_data' => '13-05-2022',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'data_type_id' => 2,
                'format' => 'MM-DD-YYYY',
                'sample_data' => '05-13-2022',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'data_type_id' => 3,
                'format' => 'hh:mm:ss',
                'sample_data' => '15:25:12',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'data_type_id' => 3,
                'format' => 'hh:mm',
                'sample_data' => '15:25',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'data_type_id' => 3,
                'format' => 'HH:MM tt',
                'sample_data' => '02:25 PM',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'data_type_id' => 3,
                'format' => 'HH:MM:SS tt',
                'sample_data' => '02:25:18 PM',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'data_type_id' => 4,
                'format' => '#,###.##',
                'sample_data' => '5,820.00',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'data_type_id' => 4,
                'format' => '# ###.##',
                'sample_data' => '5 820.02',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'data_type_id' => 5,
                'format' => '#.#',
                'sample_data' => '1008.265',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'data_type_id' => 5,
                'format' => '# ###.#',
                'sample_data' => '2 988.6586',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}