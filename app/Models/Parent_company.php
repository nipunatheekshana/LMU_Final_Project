<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parent_company extends Model
{
    use HasFactory;

    public function child_companies()
    {
        return $this->hasMany(Child_company::class);
    }
}
