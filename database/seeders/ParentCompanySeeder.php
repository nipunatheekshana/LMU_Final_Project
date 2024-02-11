<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parent_companies')->insert([
            'id' => '1',
            'name' => 'Demo Company',
            'email' => 'demo@company.com',
            'address' => '123, Demo Street, Demo City, Demo Country',
            'contacts' => '0771234567'
        ]);
    }
}
