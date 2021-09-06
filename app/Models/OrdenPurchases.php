<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenPurchases extends Model
{
    use HasFactory;

    protected $table = 'orden_purchases';

    protected $fillable = [
        'user_id','amount', 'fee', 'idtransacion',
        'status', 'type_interes'
    ];

    /**
     * Permite obtener al usuario de una Compra
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function contract()
    {
        return $this->hasOne('App\Models\Contract', 'orden_id');
    }

    public function total()
    {
        return ($this->amount + $this->fee);
    }
    
    public function status()
    {
        if ($this->status == '0'){
            return "Esperando";
        }elseif($this->status == '1'){
            return "Aprobado";
        }elseif($this->status >= '2'){
            return "Cancelado";
        }
    }

    public function cointpayment()
    {
        return $this->hasOne('Hexters\CoinPayment\Entities\CoinpaymentTransaction', 'order_id');
    }

    public function coinpayment_alternativa_link()
    {
        return $this->cointpayment->status_url;
    }
}
