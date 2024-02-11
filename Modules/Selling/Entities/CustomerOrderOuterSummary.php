<?php

namespace Modules\Selling\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerOrderOuterSummary extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'selling_customer_order_outer_summary';

    protected static function newFactory()
    {
        return \Modules\Selling\Database\factories\CustomerOrderOuterSummaryFactory::new();
    }
}
