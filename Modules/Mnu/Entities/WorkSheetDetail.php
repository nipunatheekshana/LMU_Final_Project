<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkSheetDetail extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_ws_plan_dtl';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\WorkSheetDetailFactory::new();
    }
}
