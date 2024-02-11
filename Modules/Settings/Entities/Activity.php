<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_activities';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\ActivityFactory::new();
    }
}
