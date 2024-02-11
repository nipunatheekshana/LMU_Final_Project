<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductQuality extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_product_qualities';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\ProductQualityFactory::new();
    }
}
