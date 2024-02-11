<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_log_field extends Model
{
    use HasFactory;

    public function activity_log()
    {
        return $this->belongsTo(Activity_log::class, 'activity_id', 'id');
    }
}
