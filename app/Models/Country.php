<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = [
        'id' ,'name', 'slug', 'phone_prefix', 'status'
    ];

    // busca el user del ticket
    public function getUserCountry()
    {
        return $this->belongsTo('App\Models\User', 'id', 'country_id');
    }

}
