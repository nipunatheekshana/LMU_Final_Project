<?php

namespace Modules\Settings\Entities;

use App\Models\Parent_company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'settings_companies';

    public function parent_company()
    {
        return $this->belongsTo(Parent_company::class);
    }
    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\CompanyFactory::new();
    }
}
