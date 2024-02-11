<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ManufacturingSetting extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_settings';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\ManufacturingSettingFactory::new();
    }
}
