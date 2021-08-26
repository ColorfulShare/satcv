<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'orden_purchases_id','invested', 'gain', 'capital',
        'status', 'type_interes'
    ];
}
