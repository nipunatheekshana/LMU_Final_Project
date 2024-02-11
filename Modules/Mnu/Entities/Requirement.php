<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_requirements';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\RequirementFactory::new();
    }
}
