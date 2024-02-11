<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemporyGRNDtlProcessModeSummary extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'temp_grn_dtl_process_mode_summary';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\TemporyGRNDtlProcessModeSummaryFactory::new();
    }
}
