<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NamingSeries extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'function',
        'namingFormat',
        'currentValue',
        'editable'

    ];
    protected $table = 'settings_naming_series';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\NamingSeriesFactory::new();
    }
}
