<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierGroup extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_supplier_groups';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\SupplierGroupFactory::new();
    }
}
