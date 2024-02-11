<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BoatCategory extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_boat_categories';


    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\BoatCategoryFactory::new();
    }
}
