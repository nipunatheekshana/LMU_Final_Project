<?php

namespace Modules\Selling\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerOrderInnerSummary extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'selling_customer_order_inner_summary';

    protected static function newFactory()
    {
        return \Modules\Selling\Database\factories\CustomerOrderInnerSummaryFactory::new();
    }
}
