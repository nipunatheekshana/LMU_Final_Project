<?php

namespace Modules\Quality\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdDtlLabTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'prodDtlId',
        'testTypeId',
        'resultValue',

    ];
    protected $table = 'quality_prod_dtl_lab_test_result';

    protected static function newFactory()
    {
        return \Modules\Quality\Database\factories\ProdDtlLabTestResultFactory::new();
    }
}
