<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemSupplier extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_item_suppliers';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\ItemSupplierFactory::new();
    }
}
