<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerItem extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_customer_items';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\CustomerItemFactory::new();
    }
}
