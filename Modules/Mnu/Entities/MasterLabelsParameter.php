<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterLabelsParameter extends Model
{
    use HasFactory;

    protected $fillable = [

        'label_format_id',
        'parameter',
        'parameter_description',
        'data_type',
        'format',
        'sample_data',
        'script_field',
        'script_tabel',
        'script_conditions'
    ];
    protected $table = 'mnu_master_labels_parameters';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\MasterLabelsParameterFactory::new();
    }
}
