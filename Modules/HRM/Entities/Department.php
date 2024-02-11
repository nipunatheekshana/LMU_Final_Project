<?php

namespace Modules\HRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'hrm_departments';

    protected static function newFactory()
    {
        return \Modules\HRM\Database\factories\DepartmentFactory::new();
    }
}
