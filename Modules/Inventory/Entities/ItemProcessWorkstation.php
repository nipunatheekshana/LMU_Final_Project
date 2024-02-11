<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemProcessWorkstation extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_item_process_workstations';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\ItemProcessWorkstationFactory::new();
    }
}
