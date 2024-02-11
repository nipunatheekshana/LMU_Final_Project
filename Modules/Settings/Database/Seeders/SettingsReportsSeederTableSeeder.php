<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class SettingsReportsSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::table('settings_reports')->delete();
        
        \DB::table('settings_reports')->insert(array (
            0 => 
            array (
                'id' => 1,
                'company_id' => 1,
                'report_name' => 'GRN Details',
                'report_description' => 'View GRN Details',
                'module' => 'Buying',
                'referance' => 'Fish GRN',
                'report_file_location' => 'app/Exports/UsersExport.php',
                'report_type' => 'Default',
                'default_letter_head' => NULL,
                'is_financial_report' => 0,
                'report_level' => 0,
                'enabled' => 1,
                'created_by' => '',
                'modified_by' => NULL,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
        ));
    }
}
