<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatchMethod extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_catch_method';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\CatchMethodFactory::new();
    }
}
