<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'accounting_banks';

    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\BankFactory::new();
    }
}
