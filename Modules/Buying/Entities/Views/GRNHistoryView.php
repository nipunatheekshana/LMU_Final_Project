<?php

namespace Modules\Buying\Entities\Views;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GRNHistoryView extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_grn_history_view';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\Views/GRNHistoryViewFactory::new();
    }
}
