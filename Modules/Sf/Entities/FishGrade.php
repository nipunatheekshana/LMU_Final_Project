<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FishGrade extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_fish_grades';
    
    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\FishGradeFactory::new();
    }
}
