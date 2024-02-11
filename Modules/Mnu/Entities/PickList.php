<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PickList extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_pick_list_hd';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\PickListFactory::new();
    }
}
