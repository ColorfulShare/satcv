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
use App\Http\Controllers\LiquidationController;

class RetirosController extends Controller
{
    use TwoFactor;
    public $LiquidationController;
    //
    public function __construct()
    {
        //$this->middleware('google_authenticator')->only(['retirar', 'retiro']);
        $this->LiquidationController = new LiquidationController();
    }
    public function retirar()
    {
        $user = Auth::user();

        $liquidaciones = Liquidation::where('user_id', $user->id)->get();

        return view('retiros.retirar', compact('user', 'liquidaciones'));
    }

    public function retiro(Request $request)
    {
        if(Auth::user()->type_retiro == "efectivo"){
            $wallet = 'Efectivo';

        }else{
            $validate = $request->validate([
                'codigo_correo' => 'required',
                'wallet' => 'required',
                'authenticator' => 'required',
            ]);
            $wallet = $request->wallet;
        }
        
        
        try {
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
                        'percentage' => 0.25,
                        'hash',
                        'wallet_used' => $wallet,
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
                    ])->update(['status' => 1, 'liquidation_id' => $liquidacion->id]);
                   
                    $this->LiquidationController->aprovarLiquidacion($liquidacion->id, $wallet);
                    $user->resetTwoFactorCode();
                    DB::commit();
                    return back()->with('success', 'Monto retirado con exito');
                }else{
                    
                    return back()->with('danger', 'Código incorrecto');
                }
        
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('User - sendMailFactorCode -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
        
    }

    public function changeTypeRetiro(Request $request)
    {
        $user = Auth::user();
        $user->type_retiro = $request->tipoRetiro;
        $user->save();

        return back()->with('success', 'tipo de retiro actualizado exitosamente');
    }
}
