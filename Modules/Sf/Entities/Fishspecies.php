<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fishspecies extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_fish_species';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\FishspeciesFactory::new();
    }
}
