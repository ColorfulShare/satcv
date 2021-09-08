<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','amount', 'percentage', 'descripcion',
        'status', 'tipo_transaction'
    ];

    public function user()
    {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
