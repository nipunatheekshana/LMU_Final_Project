<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryTrip extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_delivery_trip';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\DeliveryTripFactory::new();
    }
}
