<?php

namespace Modules\Buying\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrnTicket extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'buying_grn_ticket_hd';

    protected static function newFactory()
    {
        return \Modules\Buying\Database\factories\GrnTicketFactory::new();
    }
}
