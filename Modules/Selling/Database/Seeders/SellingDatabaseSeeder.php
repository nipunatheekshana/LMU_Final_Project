<?php

namespace Modules\Selling\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SellingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CustomerTypeSeederTableSeeder::class);
        $this->call(SellingCustomerGroupsTableSeeder::class);
    }
}
