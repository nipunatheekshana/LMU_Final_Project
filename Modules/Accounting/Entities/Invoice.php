<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'accounting_invoice_header';

    protected static function newFactory()
    {
        return \Modules\Accounting\Database\factories\InvoiceFactory::new();
    }
}
