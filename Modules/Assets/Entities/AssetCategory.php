<?php

namespace Modules\Assets\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetCategory extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'assets_asset_categories';

    protected static function newFactory()
    {
        return \Modules\Assets\Database\factories\AssetCategoryFactory::new();
    }
}
