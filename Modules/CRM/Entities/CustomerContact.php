<?php

namespace Modules\CRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerContact extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'crm_customercontact';

    protected static function newFactory()
    {
        return \Modules\CRM\Database\factories\CustomerContactFactory::new();
    }
}
