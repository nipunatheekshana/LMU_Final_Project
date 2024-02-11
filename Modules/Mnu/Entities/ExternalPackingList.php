<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExternalPackingList extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_ext_packing_list_hd';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\ExternalPackingListFactory::new();
    }
}
