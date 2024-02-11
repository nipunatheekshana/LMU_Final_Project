<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemManufacturer extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_item_manufacturers';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\ItemManufacturerFactory::new();
    }
}
