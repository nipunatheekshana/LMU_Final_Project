<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanySupplier extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_company_suppliers';
    
    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\CompanySupplierFactory::new();
    }
}
