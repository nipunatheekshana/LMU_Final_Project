<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FishReceiveParamSettings extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_fish_receive_param_settings';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\FishReceiveParamSettingsFactory::new();
    }
}
