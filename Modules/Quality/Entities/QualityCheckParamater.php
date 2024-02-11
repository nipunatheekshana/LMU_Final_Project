<?php

namespace Modules\Quality\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QualityCheckParamater extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'quality_qualitycheck_paramaters';

    protected static function newFactory()
    {
        return \Modules\Quality\Database\factories\QualityCheckParamaterFactory::new();
    }
}
