<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Term extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_terms';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\DataTypeFactory::new();
    }
}
