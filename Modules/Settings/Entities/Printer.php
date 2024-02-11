<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Printer extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_printers';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\PrinterFactory::new();
    }
}
