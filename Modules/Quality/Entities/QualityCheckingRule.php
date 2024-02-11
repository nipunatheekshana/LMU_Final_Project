<?php

namespace Modules\Quality\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QualityCheckingRule extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'quality_qc_rule';

    protected static function newFactory()
    {
        return \Modules\Quality\Database\factories\QualityCheckingRuleFactory::new();
    }
}
