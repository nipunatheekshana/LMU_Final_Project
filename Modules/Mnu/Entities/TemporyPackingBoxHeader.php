<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemporyPackingBoxHeader extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'temp_mnu_packing_box_hd';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\TemporyPackingBoxHeaderFactory::new();
    }
}
