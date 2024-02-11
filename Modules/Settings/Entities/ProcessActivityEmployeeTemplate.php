<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcessActivityEmployeeTemplate extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_process_activity_employee_templates';
    
    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\ProcessActivityEmployeeTemplateFactory::new();
    }
}
