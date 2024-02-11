<?php

namespace Modules\Buying\Entities\Views;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GRNHeaderDetailsView extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_grn_header_detail_view';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\Views/GRNHeaderDetailsViewFactory::new();
    }
}
