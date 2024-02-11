<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierContact extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_suppliercontacts';


    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\SupplierContactFactory::new();
    }
}
