<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransportMode extends Model
{
    use HasFactory;

    protected $fillable = [
        'TransportModeName',
        'list_index'

    ];
    protected $table = 'settings_transport_modes';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\TransportModeFactory::new();
    }
}
