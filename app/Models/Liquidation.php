<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquidation extends Model
{
   
    use HasFactory;

  protected $fillable = [
        'user_id','amount', 'total_amount', 'feed','hash'
        ,'wallet_used','status', 'type'
  ];
 

 public function user()
 {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
 }

 public function estado()
 {
      if($this->status == 1){
            return '<span class="badge bg-success">Aprobado</span>';
      }elseif($this->status == 0){
            return '<span class="badge bg-warning">En espera</span>';
      }elseif($this->status == 2){
            return '<span class="badge bg-danger">Rechazada</span>';
      }
 }

 public function tipo()
 {
      if($this->type == 0){
            return 'Socilitud';
      }elseif($this->type == 1){
            return 'Rendimientos';
      }
 }

}
