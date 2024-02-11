<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackingBox extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_packing_box_hd';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\PackingBoxFactory::new();
    }
}
