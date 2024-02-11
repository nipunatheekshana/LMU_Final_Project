<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BOMItemDetail extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_bom_item_details';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\BOMItemDetailFactory::new();
    }
}
