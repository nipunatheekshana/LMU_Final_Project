<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehouseType extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_warehouse_type';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\WarehouseTypeFactory::new();
    }
}
