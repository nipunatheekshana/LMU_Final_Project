<?php

namespace Modules\Quality\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LotLabTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'grnDtlId' ,
        'testTypeId' ,
        'resultValue' ,
    ];
    protected $table = 'quality_lot_lab_test_result';

    protected static function newFactory()
    {
        return \Modules\Quality\Database\factories\LotLabTestResultFactory::new();
    }
}
