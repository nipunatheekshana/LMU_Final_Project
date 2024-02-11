<?php

namespace Modules\Sf\Database\Seeders;

use Illuminate\Database\Seeder;

class SfFishSpeciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sf_fish_species')->delete();
        
        \DB::table('sf_fish_species')->insert(array (
            0 => 
            array (
                'id' => 1,
                'FishCode' => 'YFT',
                'FishName' => 'Yellowfin Tuna',
                'ScName' => 'Thunnus albacares',
                'ShortName' => 'Yellowfin Tuna',
                'BulkMode' => 0,
                'QRiskLevel' => 10.0,
                'default_weight_unit' => '1',
                'average_weight' => '25',
                'list_index' => 1,
                'created_by' => '2',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => '2022-06-30 06:15:28',
                'updated_at' => '2022-06-30 06:15:28',
            ),
            1 => 
            array (
                'id' => 2,
                'FishCode' => 'BIG',
                'FishName' => 'Bigeye Tuna',
                'ScName' => 'Thunnus obesus',
                'ShortName' => 'Bigeye Tuna',
                'BulkMode' => 0,
                'QRiskLevel' => 10.0,
                'default_weight_unit' => '1',
                'average_weight' => '25',
                'list_index' => 2,
                'created_by' => '2',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => '2022-06-30 06:16:32',
                'updated_at' => '2022-06-30 06:16:32',
            ),
            2 => 
            array (
                'id' => 3,
                'FishCode' => 'SWD',
                'FishName' => 'Swordfish',
                'ScName' => 'Xiphias gladius',
                'ShortName' => 'Swordfish',
                'BulkMode' => 0,
                'QRiskLevel' => 10.0,
                'default_weight_unit' => '1',
                'average_weight' => '10',
                'list_index' => 3,
                'created_by' => '2',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => '2022-06-30 06:17:18',
                'updated_at' => '2022-06-30 06:17:18',
            ),
            3 => 
            array (
                'id' => 4,
                'FishCode' => 'BRM',
                'FishName' => 'Barramundi',
                'ScName' => 'Lates calcarifer',
                'ShortName' => 'Barramundi',
                'BulkMode' => 0,
                'QRiskLevel' => 10.0,
                'default_weight_unit' => '1',
                'average_weight' => '3',
                'list_index' => 4,
                'created_by' => '2',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => '2022-06-30 06:19:28',
                'updated_at' => '2022-06-30 06:19:28',
            ),
        ));
        
        
    }
}