<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FishRejectReason extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_fish_reject_reasons';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\FishRejectReasonFactory::new();
    }
}
