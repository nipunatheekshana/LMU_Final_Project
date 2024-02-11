<?php

namespace Modules\CRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'crm_contacts';

    protected static function newFactory()
    {
        return \Modules\CRM\Database\factories\ContactFactory::new();
    }
}
