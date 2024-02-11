<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccountType extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'accounting_bank_account_types';

    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\BankAccountTypeFactory::new();
    }
}
