<?php

namespace Modules\CRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactPhone extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'crm_contact_phones';

    protected static function newFactory()
    {
        return \Modules\CRM\Database\factories\ContactPhoneFactory::new();
    }
}
