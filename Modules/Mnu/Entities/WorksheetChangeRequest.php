<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorksheetChangeRequest extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_ws_plan_change_requests';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\WorksheetChangeRequestFactory::new();
    }
}
