<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_brands';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\BrandFactory::new();
    }
}
