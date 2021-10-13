<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Liquidation;
use App\Models\Wallet;
//use Yajra\Datatables\Facades\Datatables;
use DataTables;
use App\Models\LogBonoRed;

class WalletController extends Controller
{
     /**
     * Lleva a la vista de pagos
     *
     * @return void
     */
    public function payments()
    {
        $payments = Liquidation::where([['user_id', '=', Auth::user()->id], ['status', '=', '1']])->get();

        return view('wallet.payments', compact('payments'));
    }
    
    public function utility()
    {
        return view('utility.index');
    }

    /**
     * Datatable dinámico (ServerSide) que se muestra en audit.rangos 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataUtilityServerSide(Request $request)
    {
        $user = User::find($request->id);
        
        if($user->admin == 1){
            $data = Wallet::orderBy('id', 'desc')->where('type', 0)->with('user');
        }else{
            $data = Wallet::orderBy('id', 'desc')->where('type', 0)->where('user_id', $user->id)->with('user');
        }
        

        return Datatables::of($data)
        ->addColumn('Correo', function($data){
            return $data->user->email;
        })
        ->addColumn('cantidad', function($data){
            return number_format($data->amount, 2) .' $';
        })
        ->addColumn('porcentaje', function($data){
            return number_format($data->percentage * 100,2) . ' %';
        })
        ->addColumn('estado', function($data){
            if($data->status == 0){
                return "En espera";
            }elseif($data->status == 1){
                return "Pagado";
            }elseif($data->status == 2){
                return "Cancelado";
            }elseif($data->status == 3){
                return "Reinvertido";
            }
            
        })
        ->addColumn('fecha', function($data){
            return $data->created_at->format('Y/m/d');
        })
        //->rawColumns(['accion'])
        ->make(true);
    }

    public function comision(Request $request)
    {
        $user = Auth::user();
        
        if($user->admin != 1){
            $wallets = $user->wallets->whereIn('type', [2,3,4,4]);
        }else{
            $wallets = Wallet::orderBy('id', 'desc')->whereIn('type', [2,3,4,5])->get();
        }
        return view('reports.comision', compact('wallets'));
    }

    public function bonoRed()
    {
        $administradores = User::where('type', 1)->get();
        
        foreach($administradores as $administrador){
            //Nivel 1
            if($administrador->referidos != null){
                foreach($administrador->referidos as $userNivel1){
                
                    //contratos
                    foreach($userNivel1->contracts as $contrato1){
                        
                        if(isset($contrato1)){
                            $bonoRed = LogBonoRed::orderBy('id', 'desc')->where('contracts_id', $contrato1->id)->first();
                
                            if(isset($bonoRed)){
                                
                                if(Carbon::now() >= $bonoRed->created_at->addMonth()){

                                    $this->pagarBonoRed($administrador->id, $contrato1->id, $contrato1->invested, 0.01, 3);
                                 
                                }

                            }elseif(Carbon::now() >= $contrato1->created_at->addMonth()){
                                
                                $this->pagarBonoRed($administrador->id, $contrato1->id, $contrato1->invested, 0.01, 3);
                                
                            }

                            
                        }
                    }
                    //Nivel 2
                    if($userNivel1->referidos != null){
                        foreach($userNivel1->referidos as $userNivel2){
                            
                            //contratos
                            foreach($userNivel2->contracts as $contrato2){
                                if(isset($contrato2)){
                                    $bonoRed = LogBonoRed::orderBy('id', 'desc')->where('contracts_id', $contrato2->id)->first();
                                    if(isset($bonoRed)){
                                        if(Carbon::now() >= $bonoRed->created_at->addMonth()){

                                            $this->pagarBonoRed($administrador->id, $contrato2->id, $contrato2->invested, 0.006, 4);
                                           
                                        }
        
                                    }elseif(Carbon::now() >= $contrato2->created_at->addMonth()){

                                        $this->pagarBonoRed($administrador->id, $contrato2->id, $contrato2->invested, 0.006, 4);
                                        
                                    }
        
                                    
                                }
                            }
                            //Nivel 3
                            if($userNivel2->referidos != null){
                                foreach($userNivel2->referidos as $userNivel3){
                
                                    //contratos
                                    foreach($userNivel3->contracts as $contrato3){
                                        if(isset($contrato3)){
                                            $bonoRed = LogBonoRed::orderBy('id', 'desc')->where('contracts_id', $contrato3->id)->first();
                                            if(isset($bonoRed)){
                                                if(Carbon::now() >= $bonoRed->created_at->addMonth()){

                                                    $this->pagarBonoRed($administrador->id, $contrato3->id, $contrato3->invested, 0.004, 5);
                                                  
                                                }
                
                                            }elseif(Carbon::now() >= $contrato3->created_at->addMonth()){

                                                $this->pagarBonoRed($administrador->id, $contrato3->id, $contrato3->invested, 0.004, 5);
                                               
                                            }
                
                                            
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function pagarBonoRed($administrador_id, $contract_id, $invertido, $porcentaje, $type)
    {
        Wallet::create([
            'user_id' => $administrador_id,
            'contract_id' => $contract_id,
            'amount' => $invertido * $porcentaje,
            'percentage' => $porcentaje,
            'descripcion' => 'bono red '. $porcentaje * 100 .'%',
            'payment_date' => Carbon::now()->format('Y-m-d'),
            'type' => $type
        ]);

        LogBonoRed::create([
            'amount' => $invertido * $porcentaje,
            'percentage' => $porcentaje,
            'user_id' => $administrador_id,
            'contracts_id' => $contract_id
        ]);
    }
}
