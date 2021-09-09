<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'orden_purchases_id','invested', 'gain', 'capital',
        'status', 'type_interes', 'firma_cliente'
    ];

    public function getOrden()
    {
        return $this->belongsTo('App\Models\OrdenPurchases', 'orden_purchases_id');
    }

    public function user()
    {
        return $this->getOrden->user;
    }

    public function contractExpiration()
    {
        $this->created_at = Carbon::now();
        return $this->created_at->addYear();
    }

    public function diffDaysExpiration()
    {
        return $this->contractExpiration()->diffInDays();
    }
    public function countDaysContract()
    {
        return $this->created_at->diffInDays();
    }

    public function wallets()
    {
        return $this->hasMany('App\Models\Wallet', 'contract_id');
    }

    public function retirado()
    {
        return $this->wallets->where('status', 1)->sum('amount');
    }

    public function productividad()
    {
        return ($this->type_interes == 'lineal') ? ($this->gain / $this->invested ) * 100 : ((($this->capital + $this->retirado() ) - $this->invested ) / $this->invested ) * 100;
    }

    public function estado()
    {
        if($this->status == 1){
            return '<span class="badge bg-success">Activo</span>';
        }else{
            return '<span class="badge bg-danger">Culminado</span>';
        }
    }

    public function firma_cliente()
    {
        
    }
    
}
