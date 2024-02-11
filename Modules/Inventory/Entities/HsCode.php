<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HsCode extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'inventory_hs_codes';

    protected static function newFactory()
    {
        return \Modules\Inventory\Database\factories\HsCodeFactory::new();
    }
}
