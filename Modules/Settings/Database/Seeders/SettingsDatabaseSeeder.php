<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CountrySeederTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(DomainTableSeeder::class);
        $this->call(TransportModesTableSeeder::class);
        $this->call(SettingsBarcodeTypesTableSeeder::class);
        $this->call(SettingsTimezonesTableSeeder::class);
        $this->call(SettingsLanguagesTableSeeder::class);
        $this->call(SettingsDataTypesTableSeeder::class);
        $this->call(SettingsDataTypesFormatsTableSeeder::class);
        $this->call(SettingsReportsSeederTableSeeder::class);
        $this->call(NamingSeriesTableSeeder::class);
    }
}
