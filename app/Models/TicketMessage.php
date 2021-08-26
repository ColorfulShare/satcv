<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    use HasFactory;

    protected $table = 'tickets_message';

    protected $fillable = [
         'user','admin', 'ticket', 'type', 'message'
    ];
    
    // busca el user del mensaje
    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user', 'id');
    }

    // busca el admin del mensaje
    public function getAdmin()
    {
        return $this->belongsTo('App\Models\User', 'admin', 'id');
    }
   
    // busca el ticket del mensaje
    public function getTicket()
    {
        return $this->belongsTo('App\Models\Ticket', 'ticket', 'id');
    }
}
