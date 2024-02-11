<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierAddress extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_supplieraddress';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\SupplierAddressFactory::new();
    }
}
