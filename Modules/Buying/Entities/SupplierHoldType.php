<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierHoldType extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_supplier_hold_types';
    
    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\SupplierHoldTypeFactory::new();
    }
}
