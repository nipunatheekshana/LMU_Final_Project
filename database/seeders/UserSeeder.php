<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => '1',
            'name' => 'MISL Admin',
            'email' => 'admin@mislholdings.com',
            'password' => Hash::make(123456),
            'user_level'=> 'MISLuser'
        ]);
    }
}
