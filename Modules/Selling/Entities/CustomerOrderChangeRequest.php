<?php

namespace Modules\Selling\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerOrderChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'selling_customer_order_change_requests';

    protected static function newFactory()
    {
        return \Modules\Selling\Database\factories\CustomerOrderChangeRequestFactory::new();
    }
}
