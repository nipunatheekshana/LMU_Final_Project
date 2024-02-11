<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrnTicketFishDetail extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_grn_ticket_fish_dtl';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\GrnTicketFishDetailFactory::new();
    }
}
