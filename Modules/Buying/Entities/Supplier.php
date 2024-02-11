<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_suppliers';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\SupplierFactory::new();
    }
}
