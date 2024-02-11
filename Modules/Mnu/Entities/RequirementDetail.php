<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequirementDetail extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_requirements_dtl';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\RequirementDetailFactory::new();
    }
}
