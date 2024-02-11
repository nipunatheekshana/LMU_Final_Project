<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemporyGrnDtlReceiveSummary extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'temp_grn_dtl_receive_summary';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\TemporyGrnDtlReceiveSummaryFactory::new();
    }
}
