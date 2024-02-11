<?php

namespace Modules\Selling\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerGroup extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'selling_customer_groups';

    protected static function newFactory()
    {
        return \Modules\Selling\Database\factories\CustomerGroupFactory::new();
    }
}
