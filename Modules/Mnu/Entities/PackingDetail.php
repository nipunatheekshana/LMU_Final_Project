<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackingDetail extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_packing_dtl';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\PackingDetailFactory::new();
    }
}
