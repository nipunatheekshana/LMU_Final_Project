<?php

namespace Modules\HRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gender extends Model
{
    use HasFactory;

    protected $fillable = [
        'gender',
    ];
    protected $table = 'hrm_genders';


    protected static function newFactory()
    {
        return \Modules\HRM\Database\factories\GenderFactory::new();
    }
}
