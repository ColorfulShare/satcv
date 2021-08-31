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


}
