<?php

namespace Modules\Buying\Entities\Views;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GRNProductionDetailsView extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_grn_production_dtl_view';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\Views/GRNDetailsViewFactory::new();
    }
}
