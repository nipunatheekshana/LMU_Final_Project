<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FishCoolingMethod extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_fish_cooling_methods';
    
    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\FishCoolingMethodFactory::new();
    }
}
