<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoatHoldType extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_boat_hold_types';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\BoatHoldTypeFactory::new();
    }
}
