<?php

namespace Modules\HRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Designations extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'hrm_designations';

    protected static function newFactory()
    {
        return \Modules\HRM\Database\factories\DesignationsFactory::new();
    }
}
