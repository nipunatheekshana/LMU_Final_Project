<?php

namespace Modules\CRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddressType extends Model
{
    use HasFactory;

    protected $fillable = [
        'AddressType',
    ];
    protected $table = 'crm_address_types';


    public function Addresses()
    {
        return $this->hasMany(Address::class,'AddressType', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\CRM\Database\factories\AddressTypeFactory::new();
    }
}
