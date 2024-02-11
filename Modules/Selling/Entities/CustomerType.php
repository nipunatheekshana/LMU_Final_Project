<?php

namespace Modules\Selling\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerType extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'selling_customer_types';

    protected static function newFactory()
    {
        return \Modules\Selling\Database\factories\CustomerTypeFactory::new();
    }
}
