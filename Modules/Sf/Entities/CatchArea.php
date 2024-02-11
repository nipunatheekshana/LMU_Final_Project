<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatchArea extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_catch_area';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\CatchAreaFactory::new();
    }
}
