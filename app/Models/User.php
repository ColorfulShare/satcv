<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\TwoFactorCode;

class User extends Authenticatable 
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    //use TwoFactorAuthenticatable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'lastname',
        'password',
        'msj_admin',
        'QR_code',
        'activar_2fact',
        'two_factor_code_email',
        'two_factor_expires_at',
        'referred_id',
        'dni',
        'birth',
        'dni_expedition',
        'phone',
        'mobile_phone',
        'country_id',
        'document_type',
        'city_dni',
        'address',
        'district',
        'city',
        'department',
        'photo_dni_back',
        'selfie_document',
        'photo_document'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $dates = [
        'two_factor_expires_at'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function fullName()
    {
        return $this->name .' '.$this->lastname;
    }

    public function ordenes()
    {
        return $this->hasMany('App\Models\OrdenPurchases', 'user_id');
    }

    public function contracts()
    {
        return $this->hasManyThrough('App\Models\Contract', 'App\Models\OrdenPurchases');
    }

    public function wallets()
    {
        return $this->hasMany('App\Models\Wallet', 'user_id');
    }

    public function saldoDisponible()
    {
        return number_format($this->wallets->where('status', 0)->sum('amount'), 2);
        
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code_email = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code_email = null;
        $this->two_factor_expires_at = null;
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }

    public function MailTwoFactorCode()
    {
        $this->generateTwoFactorCode();
        $this->notify(new TwoFactorCode);
        return true;
        if($this->notify(new TwoFactorCode)){
            return true;
        }else{
            return false;
        }
        
    }

    public function countrie()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function invertido()
    {
        return $this->contracts->sum('invested');
    }

    public function ganancia()
    {
        return $this->contracts->sum('gain');
    }

    public function referidos()
    {
        return $this->hasMany('App\Models\User', 'referred_id');
    }
    
    public function refirio()
    {
        return $this->belongsTo('App\Models\User', 'referred_id');
    }

    public function contractsAdministrator()
    {
        $contractsReferidos = collect();
       foreach ($this->referidos as $key => $referido) {
            $contractsReferidos->push($referido->contracts);
        } 
        $contracts = $this->contracts;
        $contractsReferidos->push($contracts);
        return $contractsReferidos;

    }

    public function gananciaAdministrator()
    {
        $gananciaReferidos = 0;
        foreach ($this->referidos as $key => $referido) {
             $gananciaReferidos += $referido->contracts->sum('gain');
         } 
         $gananciaReferidos += $this->contracts->sum('gain');
        return $gananciaReferidos;
    }

    public function portafolio()
    {
        $capital = 0;
        foreach($this->referidos as $referido){
            $capital += $referido->contracts->sum('capital');
        }
        $capital+= $this->contracts->sum('capital');

        return $capital;
    }

    public function comision()
    {
        return $this->wallets()->where('type', 1)->sum('amount');
    }

     public function getContracts()
    {
        return $this->belongsTo('App\Models\Contract', 'invested');
    }
}
