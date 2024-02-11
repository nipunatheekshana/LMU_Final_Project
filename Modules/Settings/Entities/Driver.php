<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_drivers';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\DriverFactory::new();
    }
}
