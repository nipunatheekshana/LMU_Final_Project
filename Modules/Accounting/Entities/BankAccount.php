<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'accounting_bank_accounts';

    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\BankAccountFactory::new();
    }
}
