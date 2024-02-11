<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeaFoodSetting extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_settings';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\SeaFoodSettingFactory::new();
    }
}
