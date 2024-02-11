<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryNote extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_delivery_note';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\DeliveryNoteFactory::new();
    }
}
