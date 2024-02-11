<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workstation extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_workstations';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\WorkstationFactory::new();
    }
}
