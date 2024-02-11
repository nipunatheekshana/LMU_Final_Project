<?php

namespace Modules\CRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'crm_addresses';


    public function Address_type()
    {
        return $this->belongsTo(AddressType::class,'AddressType', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\CRM\Database\factories\AddressFactory::new();
    }
}
