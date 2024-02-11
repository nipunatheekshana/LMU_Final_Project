<?php

namespace Modules\Sf\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SfDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $this->call(SfFishSpeciesTableSeeder::class);
        $this->call(SfCuttingTypeTableSeeder::class);
        $this->call(SfCatchAreaTableSeeder::class);
        $this->call(SfCatchMethodTableSeeder::class);
        $this->call(SfLandingsiteTableSeeder::class);
    }
}
