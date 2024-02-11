<?php

namespace Modules\HRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'salutation',
    ];

    protected $table = 'hrm_salutations';

    protected static function newFactory()
    {
        return \Modules\HRM\Database\factories\SalutationFactory::new();
    }
}
