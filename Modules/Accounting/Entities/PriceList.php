<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriceList extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'accounting_price_list';

    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\PriceListFactory::new();
    }
}
