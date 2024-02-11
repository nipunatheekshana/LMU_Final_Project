<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'accounting_exchange_rate';

    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\ExchangeRateFactory::new();
    }
}
