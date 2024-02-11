<?php

namespace Modules\Quality\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QualityRuleParameter extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'quality_qc_rule_parameters';

    protected static function newFactory()
    {
        return \Modules\Quality\Database\factories\QualityRuleParameterFactory::new();
    }
}
