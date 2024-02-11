<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airline extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'inventory_airlines';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\BrandFactory::new();
    }
}
