<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemAlternative extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_item_alternatives';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\ItemAlternativeFactory::new();
    }
}
