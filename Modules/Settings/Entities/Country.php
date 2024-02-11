<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;
    protected $table = 'settings_countries';

    protected $fillable = [
        'country_code ',
        'country_name',
        'date_format',
        'time_zone',
    ];
    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\CountryFactory::new();
    }
}
