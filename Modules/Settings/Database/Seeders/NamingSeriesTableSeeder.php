<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Settings\Entities\NamingSeries;

class NamingSeriesTableSeeder extends Seeder
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
            ['id' => 1, 'function' => 'Customer Order', 'namingFormat' => 'CO.YYYY.DD.MM.####', 'currentValue' => 1,'editable' => true],
            ['id' => 2, 'function' => 'Planning Number', 'namingFormat' => 'PL.######', 'currentValue' => 1, 'editable' => false],
            ['id' => 3, 'function' => 'Requirement ID', 'namingFormat' => 'R.######', 'currentValue' => 1, 'editable' => false],
            ['id' => 4, 'function' => 'Raw Material Cost ID', 'namingFormat' => 'RMC.######', 'currentValue' => 1, 'editable' => false],
            ['id' => 5, 'function' => 'General Packing List', 'namingFormat' => 'GPL.#######', 'currentValue' => 1, 'editable' => true],
            ['id' => 6, 'function' => 'Export Packing List', 'namingFormat' => 'EPL.#######', 'currentValue' => 1, 'editable' => true],
            ['id' => 7, 'function' => 'Invoice', 'namingFormat' => 'INV.#######', 'currentValue' => 1, 'editable' => true],
            ['id' => 8, 'function' => 'Lab Test', 'namingFormat' => 'TEST.#######', 'currentValue' => 1, 'editable' => true],
            ['id' => 9, 'function' => 'Test Sample', 'namingFormat' => 'SAM.#######', 'currentValue' => 1, 'editable' => true],
            ['id' => 10, 'function' => 'Delivery note', 'namingFormat' => 'Del.#######', 'currentValue' => 1, 'editable' => true],
            ['id' => 11, 'function' => 'Pick List', 'namingFormat' => 'PiL.#######', 'currentValue' => 1, 'editable' => true],
            ['id' => 12, 'function' => 'GRN ticket', 'namingFormat' => 'GT.#######', 'currentValue' => 1, 'editable' => true],
            ['id' => 13, 'function' => 'qGRN No', 'namingFormat' => 'qGRN.#######', 'currentValue' => 1, 'editable' => true],




        ];
        NamingSeries::insert($object);
    }
}
