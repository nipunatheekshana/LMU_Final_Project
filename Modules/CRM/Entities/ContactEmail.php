<?php

namespace Modules\CRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactEmail extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'crm_contact_emails';

    protected static function newFactory()
    {
        return \Modules\CRM\Database\factories\ContactEmailFactory::new();
    }
}
