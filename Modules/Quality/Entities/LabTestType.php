<?php

namespace Modules\Quality\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabTestType extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'quality_lab_test_types';

    protected static function newFactory()
    {
        return \Modules\Quality\Database\factories\LabTestTypesFactory::new();
    }
}
