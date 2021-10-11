<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBonoRed extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','amount', 'percentage', 'user_id', 'contracts_id'
    ];

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract', 'contract_id', 'id');
    }

    public function user()
    {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
