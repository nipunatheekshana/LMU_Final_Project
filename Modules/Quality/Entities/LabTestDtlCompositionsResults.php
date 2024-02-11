<?php

namespace Modules\Quality\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabTestDtlCompositionsResults extends Model
{
    use HasFactory;

    protected $table = 'quality_lab_test_dtl_compositions_results';
    protected $fillable = [
        'compHdId',
        'testTypeId',
        'testDtlTypeId',
        'created_by',
        'modified_by',
        'testResultValue',
    ];

    protected static function newFactory()
    {
        return \Modules\Quality\Database\factories\LabTestDtlCompositionsResultsFactory::new();
    }
}
