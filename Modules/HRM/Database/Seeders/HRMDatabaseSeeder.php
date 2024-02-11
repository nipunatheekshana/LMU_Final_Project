<?php

namespace Modules\HRM\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class HRMDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(GenderSeederTableSeeder::class);
        $this->call(SalutationTableSeeder::class);
        $this->call(HrmStatusTableSeeder::class);
    }
}
