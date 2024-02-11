<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Settings\Entities\TransportMode;

class TransportModesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $object = [
            ['id' => 1, 'TransportModeName' => 'Land'],
            ['id' => 2, 'TransportModeName' => 'Sea'],
            ['id' => 3, 'TransportModeName' => 'Air'],
        ];
        TransportMode::insert($object);
    }
}
