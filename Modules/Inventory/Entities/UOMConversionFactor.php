<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UOMConversionFactor extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_uom_conversion_factors';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\UOMConversionFactorFactory::new();
    }
}
