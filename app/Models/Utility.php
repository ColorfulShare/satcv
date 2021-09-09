<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utility extends Model
{
    use HasFactory;

    public function log()
    {
        return $this->hasMany('App\Models\Log_utility', 'utility_id');
    }

    public function amount_lineal()
    {
        return $this->log->where('contract.type_interes', 'lineal')->sum('amount');
    }

    public function amount_compuesto()
    {
        return $this->log->where('contract.type_interes', 'compuesto')->sum('amount');
    }
}
