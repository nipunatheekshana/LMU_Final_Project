<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;
    protected $table = 'settings_currencies';

    protected $fillable = [
        'currency_code ',
        'currency_name',
        'currency_symbol',
        'fraction',
        'fraction_units',
        'number_format',
    ];

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\CurrencyFactory::new();
    }
}
