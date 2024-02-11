<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcessActivity extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_process_activities';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\ProcessActivityFactory::new();
    }
}
