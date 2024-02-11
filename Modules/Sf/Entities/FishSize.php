<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FishSize extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_fish_size_matrix';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\FishSizeFactory::new();
    }
}
