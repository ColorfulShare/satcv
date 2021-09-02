<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_liquidation extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallets_id','liquidations_id'
  ];
}
