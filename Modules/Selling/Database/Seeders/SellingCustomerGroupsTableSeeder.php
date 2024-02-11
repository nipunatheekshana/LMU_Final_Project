<?php

namespace Modules\Selling\Database\Seeders;

use Illuminate\Database\Seeder;

class SellingCustomerGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        // \DB::table('selling_customer_groups')->delete();
        
        \DB::table('selling_customer_groups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'CusGroupName' => 'All Customers Group',
                'isGroup' => 1,
                'list_index' => '1',
                'created_by' => 'Migrations',
                'modified_by' => NULL,
                'enabled' => 1,
                'created_at' => now(),
                'updated_at' => NULL,
                'ParentCusGroupID' => NULL,
            )
        ));
        
        
    }
}