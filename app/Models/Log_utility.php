<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_utility extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id','wallet_id', 'percentage', 'month',
        'year', 'previoues_amount', 'current_amount', 'utility_id'
    ];

    public function contract()
    {
        return $this->belongsTo('App\Models\Contract', 'contract_id', 'id');
    }

    public function user()
    {
        return $this->contract->getOrden->user;
    }
}
