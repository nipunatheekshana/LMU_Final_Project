<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrnTicketBoatDetail extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_grn_ticket_boat_dtl';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\GrnTicketBoatDetailFactory::new();
    }
}
