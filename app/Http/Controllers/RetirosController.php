<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\TwoFactor;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Wallet;

class RetirosController extends Controller
{
    use TwoFactor;
    //
    public function __construct()
    {
        $this->middleware('google_authenticator')->only(['retirar', 'retiro']);
    }
    public function retirar()
    {
        $user = Auth::user();

        return view('retiros.retirar', compact('user'));
    }

    public function retiro(Request $request)
    {
        $validate = $request->validate([
            'codigo_correo' => 'required',
            'wallet' => 'required',
            'authenticator' => 'required',
        ]);
        
        try {
            if ($validate) {

                $user = User::find(Auth::id());

                if($this->checkCode($user, $request->authenticator) && $this->checkCodeMail($user, $request->codigo_correo)){

                    if(Carbon::parse($user->two_factor_expires_at)->lt(Carbon::now())){
                        $user->resetTwoFactorCode();
                        return back()->with('danger','El código de dos factores ha expirado. Ingrese nuevamente.');
                    }

                    $wallet = Wallet::where([
                        ['user_id', '=', $user->id],
                        ['status', '=', 0],
                        ['tipo_transaction', '=', 1]
                    ])->update(['status' => 1]);

                    $user->resetTwoFactorCode();
                    
                    return back()->with('success', 'Monto retirado con exito');
                }else{
                    return back()->with('danger', 'Código incorrecto');
                }
            }
        } catch (\Throwable $th) {
            Log::error('User - sendMailFactorCode -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
        
    }
}
