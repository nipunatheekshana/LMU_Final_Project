<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataTypeFormat extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_data_types_formats';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\DataTypeFormatFactory::new();
    }
}
