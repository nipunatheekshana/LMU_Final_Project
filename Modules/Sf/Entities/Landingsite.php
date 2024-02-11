<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Landingsite extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_landingsite';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\LandingsiteFactory::new();
    }
}
