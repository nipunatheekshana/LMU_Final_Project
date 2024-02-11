<?php

namespace Modules\Selling\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerNotifyparty extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'selling_customernotifyparty';

    protected static function newFactory()
    {
        return \Modules\Selling\Database\factories\CustomerNotifypartyFactory::new();
    }
}
