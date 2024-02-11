<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcessWorkstation extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_process_workstations';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\ProcessWorkstationFactory::new();
    }
}
