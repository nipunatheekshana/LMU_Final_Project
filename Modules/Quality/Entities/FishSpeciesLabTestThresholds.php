<?php

namespace Modules\Quality\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FishSpeciesLabTestThresholds extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'quality_fish_species_lab_test_thresholds';

    protected static function newFactory()
    {
        return \Modules\Quality\Database\factories\FishSpeciesLabTestThresholdsFactory::new();
    }
}
