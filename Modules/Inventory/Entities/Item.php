<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';
    protected $fillable = [
        'rm_species',
        'ReceivePresentation',
        'ReceiveGrade',
        'ReceiveSizeVarient',
        'CompanyID',
        'Item_Code',
        'item_name',
        'CompanyID',
        'Inventory_code',
        'Item_description',
        'rm_species',
        'ReceivePresentation',
        'ReceiveGrade',
        'ReceiveSizeVarient',
        'item_group',
        'stock_uom',
        'purchase_uom',
        'weight_uom',
        'avg_weight_per_unit',
        'is_inspection_required_before_receive',
        'before_receive_rule',
        'is_inspection_required_before_delivery',
        'before_delivery_rule',
        'is_stock_item',
        'is_seafood_item',
        'is_purchase_item',
        'create_unit_batch',
        'list_index',
        'enabled'
    ];

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\ItemFactory::new();
    }
}
