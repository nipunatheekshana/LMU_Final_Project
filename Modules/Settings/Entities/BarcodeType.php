<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarcodeType extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_barcode_types';
    
    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\BarcodeTypeFactory::new();
    }
}
