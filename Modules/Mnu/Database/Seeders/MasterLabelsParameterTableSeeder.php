<?php

namespace Modules\Mnu\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Mnu\Entities\MasterLabelsParameter;

class MasterLabelsParameterTableSeeder extends Seeder
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
            [
                'label_format_id' => 1,
                'parameter' => '@CusRefNo',
                'parameter_description' => 'Customer Referance Number',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'CU1288',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@BatchNo',
                'parameter_description' => 'Batch Number',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'B22051901',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@CustName',
                'parameter_description' => 'Customer Name ',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'ABC Company (Pvt) Ltd',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@CusAdd1',
                'parameter_description' => 'Customer Address Line 1 ',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'Sample Address Line 1',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@CusAdd2',
                'parameter_description' => 'Customer Address Line 2 ',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'Sample Address Line 2',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@ItemCode',
                'parameter_description' => 'Product Code ',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'SAMPLE-PRODUCT',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@ScName',
                'parameter_description' => 'Scientific Name ',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'Scientific Name',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@PcsWg',
                'parameter_description' => 'Piece Weight',
                'data_type' => 4,
                'format' => '',
                'sample_data' => '3.223KG',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@FishNo',
                'parameter_description' => 'Fish Number',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'F10002',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@GrnNo',
                'parameter_description' => 'GRN Number',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'GRN2211047',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@PcsNo',
                'parameter_description' => 'Piece Number',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'PCS8027',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@VessID',
                'parameter_description' => 'Vessel ID',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'V282666',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@CatchArea',
                'parameter_description' => 'Catch Area',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 'Catch Area 01',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@ProdDate',
                'parameter_description' => 'Production Date',
                'data_type' => 2,
                'format' => '',
                'sample_data' => '2022-01-12',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@ExpDate',
                'parameter_description' => 'Expiry Date',
                'data_type' => 2,
                'format' => '',
                'sample_data' => '2022-07-03',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@Barcode',
                'parameter_description' => 'Barcode',
                'data_type' => 1,
                'format' => '',
                'sample_data' => '12345678',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@GT_BG_WGT_BAR',
                'parameter_description' => 'GTIN Weight Barcode',
                'data_type' => 1,
                'format' => '',
                'sample_data' => '1.27127E+13',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@GT_BG_WGT_HR',
                'parameter_description' => 'GTIN Weight Human Read',
                'data_type' => 1,
                'format' => '',
                'sample_data' => '1.27127E+13',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@EAN13BC',
                'parameter_description' => 'EAN13',
                'data_type' => 1,
                'format' => '',
                'sample_data' => '1.34576E+12',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@BestBefore',
                'parameter_description' => 'Best Before Date',
                'data_type' => 2,
                'format' => '',
                'sample_data' => '2022-05-06',
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],
            [
                'label_format_id' => 1,
                'parameter' => '@PrintQty',
                'parameter_description' => 'Print Quantity',
                'data_type' => 1,
                'format' => '',
                'sample_data' => 1,
                'script_field' => '',
                'script_tabel' => '',
                'script_conditions' => ''
            ],

        ];
        MasterLabelsParameter::insert($object);
    }
}
