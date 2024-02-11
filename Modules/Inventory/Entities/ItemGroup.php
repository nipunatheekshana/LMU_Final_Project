<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemGroup extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_item_groups';


    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\ItemGroupFactory::new();
    }
}
