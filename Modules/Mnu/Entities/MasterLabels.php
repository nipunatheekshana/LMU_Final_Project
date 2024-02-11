<?php

namespace Modules\Mnu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterLabels extends Model
{
    use HasFactory;

    protected $table = 'mnu_master_labels';
    protected $fillable = [
        'id',
        'formatCode ',
        'formatName',
        'formatDescription',
    ];
    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\MasterLabelsFactory::new();
    }
}
