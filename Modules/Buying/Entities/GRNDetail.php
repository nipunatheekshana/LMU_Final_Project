<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GRNDetail extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_fish_grn_dtl';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\GRNDetailFactory::new();
    }
}
