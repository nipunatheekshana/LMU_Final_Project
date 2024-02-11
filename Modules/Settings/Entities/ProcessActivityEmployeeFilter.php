<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcessActivityEmployeeFilter extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_process_activity_employee_filters';
    
    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\ProcessActivityEmployeeFilterFactory::new();
    }
}
