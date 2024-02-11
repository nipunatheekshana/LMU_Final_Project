<?php

namespace Modules\Mnu\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Mnu\Entities\MasterLabels;

class MasterLabelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $object= [
            ['id'=>1,'formatCode' => 1, 'formatName'=>'InnerItem','formatDescription'=>'jjf'],
            ['id'=>2,'formatCode' => 2, 'formatName'=>'OuterItem','formatDescription'=>'mmm'],
        ];

        MasterLabels::insert($object);
    }
}
return TemporyGRNDtlProcessModeSummary::all();
