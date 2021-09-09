<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\TwoFactor;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Wallet;
use App\Models\Liquidation;
use App\Models\Log_liquidation;
use DB;
use Illuminate\Support\Facades\Log;

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

        $liquidaciones = Liquidation::where('user_id', $user->id)->get();

        return view('retiros.retirar', compact('user', 'liquidaciones'));
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
                DB::beginTransaction();
                $user = User::find(Auth::id());

                if($this->checkCode($user, $request->authenticator) && $this->checkCodeMail($user, $request->codigo_correo)){

                    if(Carbon::parse($user->two_factor_expires_at)->lt(Carbon::now())){
                        $user->resetTwoFactorCode();
                        return back()->with('danger','El código de dos factores ha expirado. Ingrese nuevamente.');
                    }
                    $saldo = Wallet::where([
                        ['user_id', '=', $user->id],
                        ['status', '=', 0],
                    ])->sum('amount');

                    $liquidacion = Liquidation::create([
                        'user_id' => $user->id,
                        'amount' => $saldo,
                        'total_amount' => $saldo,
                        'feed' => 0,
                        'hash',
                        'wallet_used' => $request->wallet,
                        'status' => 0,
                        'type' => 1
                    ]);

                    $ids = Wallet::where([
                        ['user_id', '=', $user->id],
                        ['status', '=', 0],
                    ])->pluck('id');

                    foreach($ids as $id){
                        $log = Log_liquidation::create([
                            'wallets_id' => $id,
                            'liquidations_id' => $liquidacion->id
                        ]);
                    }

                    $wallet = Wallet::where([
                        ['user_id', '=', $user->id],
                        ['status', '=', 0],
                    ])->update(['status' => 1]);

                    $user->resetTwoFactorCode();
                    DB::commit();
                    return back()->with('success', 'Monto retirado con exito');
                }else{
                    
                    return back()->with('danger', 'Código incorrecto');
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('User - sendMailFactorCode -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
        
    }
}
