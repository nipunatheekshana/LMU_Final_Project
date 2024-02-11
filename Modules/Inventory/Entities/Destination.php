<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destination extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'inventory_destinations';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\BrandFactory::new();
    }
}
