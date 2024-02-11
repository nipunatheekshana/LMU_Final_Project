<?php

namespace Modules\CRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'crm_customeraddress';

    protected static function newFactory()
    {
        return \Modules\CRM\Database\factories\CustomerAddressFactory::new();
    }
}
