<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scale extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_scales';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\ScaleFactory::new();
    }
}
