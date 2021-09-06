<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;

class SolicitudRetiro extends Model
{
    use HasFactory;

    protected $fillable = [
        'contracts_id','amount', 'percentage','status', 'wallet'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contracts_id');
    }

    public function status()
    {
        if($this->status == 0){
            return "En espera";
        }elseif($this->status == 1){
            return "Retirado";
        }elseif($this->status == 2){
            return "Cancelado";
        }
    }

    public function user()
    {
        return $this->contract->user();
    }
}
