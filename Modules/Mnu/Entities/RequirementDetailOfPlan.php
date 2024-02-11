<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequirementDetailOfPlan extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_requirements_dtl_plan';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\RequirementDetailOfPlanFactory::new();
    }
}
