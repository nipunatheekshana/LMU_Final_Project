<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UOM extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_uom';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\UOMFactory::new();
    }
}
