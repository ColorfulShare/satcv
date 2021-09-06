<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TicketMessage;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
         'user', 'issue', 'status', 'priority'
    ];

    // busca el user del ticket
    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user', 'id');
    }

    public function getMsj($ticket)
    {

        $ticket_msj = TicketMessage::where('ticket', $ticket)->orderBy('created_at', 'desc')->first();

        return $ticket_msj;
    }
}
