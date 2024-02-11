<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_reports';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\ReportFactory::new();
    }
}
