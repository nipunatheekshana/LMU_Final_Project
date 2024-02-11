<?php

namespace Modules\Sf\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyBoat extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'sf_company_boats';

    protected static function newFactory()
    {
        return \Modules\Sf\Database\factories\CompanyBoatFactory::new();
    }
}
