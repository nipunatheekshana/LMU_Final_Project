<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerItemParameter extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_customer_item_parameters';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\CustomerItemParameterFactory::new();
    }
}
