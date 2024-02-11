<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Boat extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_boats';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\BoatFactory::new();
    }
}
