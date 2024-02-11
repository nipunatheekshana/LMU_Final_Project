<?php

namespace Modules\HRM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'hrm_status';

    protected static function newFactory()
    {
        return \Modules\HRM\Database\factories\StatusFactory::new();
    }
}
