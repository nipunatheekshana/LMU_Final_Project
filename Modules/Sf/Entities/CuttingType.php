<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CuttingType extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_cutting_type';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\CuttingTypeFactory::new();
    }
}
