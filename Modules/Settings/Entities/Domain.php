<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Domain extends Model
{
    use HasFactory;
    protected $table = 'settings_domains';

    protected $fillable = [
        'domain_name ',
    ];

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\DomainFactory::new();
    }
}
