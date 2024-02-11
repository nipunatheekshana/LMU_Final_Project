<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionDetail extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_production_dtl';
    
    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\ProductionDetailFactory::new();
    }
}
