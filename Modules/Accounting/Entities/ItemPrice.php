<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemPrice extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'accounting_item_price';

    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\ItemPriceFactory::new();
    }
}
