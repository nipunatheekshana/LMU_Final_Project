<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrnDetailPayRate extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_fish_grn_dtl_pay_rate';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\GrnDetailPayRateFactory::new();
    }
}
