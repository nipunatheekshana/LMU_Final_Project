<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_vehicles';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\VehicleFactory::new();
    }
}
