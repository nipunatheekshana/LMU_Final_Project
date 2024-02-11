<?php

namespace Modules\Mnu\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MnuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(MasterLabelsTableSeeder::class);
        $this->call(MasterLabelsParameterTableSeeder::class);

    }
}
