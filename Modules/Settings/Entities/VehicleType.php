<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_transport_vehicle_types';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\VehicleTypeFactory::new();
    }
}
