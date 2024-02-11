<?php

namespace Modules\Selling\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'selling_customers';

    protected static function newFactory()
    {
        return \Modules\Selling\Database\factories\CustomerFactory::new();
    }
}
