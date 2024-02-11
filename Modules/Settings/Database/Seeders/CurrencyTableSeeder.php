<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Settings\Entities\Currency;

class CurrencyTableSeeder extends Seeder
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
            ['id' => 1, 'currency_code' => 'LKR', 'currency_name' => 'Sri Lankan rupees','currency_symbol' => 'Rs','list_index' => 1,'fraction' => 'cent','fraction_units' => 2,'fraction' => '#,###.##'],
        ];
        Currency::insert($object);
    }
}
