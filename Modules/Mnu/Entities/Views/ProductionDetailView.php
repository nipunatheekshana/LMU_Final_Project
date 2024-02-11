<?php

namespace Modules\Mnu\Entities\Views;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionDetailView extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'mnu_production_dtl_view';

    protected static function newFactory()
    {
        return \Modules\Mnu\Database\factories\Views/ProductionDetailViewFactory::new();
    }
}
