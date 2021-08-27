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
        'status', 'type_interes'
    ];

    public function getOrden()
    {
        return $this->belongsTo('App\Models\OrdenPurchases', 'orden_purchases_id');
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
    
}
