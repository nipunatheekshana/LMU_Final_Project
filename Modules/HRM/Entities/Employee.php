<?php

namespace Modules\HRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'hrm_employees';

    protected static function newFactory()
    {
        return \Modules\HRM\Database\factories\EmployeeFactory::new();
    }
}
