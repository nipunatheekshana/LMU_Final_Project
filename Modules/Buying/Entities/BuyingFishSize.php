<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuyingFishSize extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_grn_fish_size_matrix';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\BuyingFishSizeFactory::new();
    }
}
