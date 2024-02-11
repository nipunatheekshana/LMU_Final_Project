<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QGrn extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_fish_qgrn_hd';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\QGrnFactory::new();
    }
}
