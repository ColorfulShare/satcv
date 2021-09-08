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
    
    public function administrators()
    {
       return view('wallet.administrators');

        // return view('wallet.administrators', compact('administrators'));
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
        $data = Wallet::orderBy('id', 'desc')->with('user');

        return Datatables::of($data)
        ->addColumn('Correo', function($data){
            return $data->user->email;
        })
        ->addColumn('porcentaje', function($data){
            return $data->percentage * 100 . ' %';
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

}
