<?php

namespace App\Http\Controllers;

use App\Models\OrdenPurchases;
use App\Models\Wallet;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    //

    /**
     * lleva a la vista de informes
     *
     * @return void
     */
    public function index()
    {
    
      $ordenes = OrdenPurchases::where('user_id', '=', Auth::user()->id)->get();

      return view('reports.pedido', compact('ordenes'));
    }
  
    public function indexPedidos()
    {
        $user = auth()->user();
        if($user->admin == 1){
            $ordenes = OrdenPurchases::orderBy('id', 'desc')->get();
        }else{
            $ordenes = OrdenPurchases::orderBy('id', 'desc')->where('user_id', $user->id)->get();
    }


        return view('reports.index', compact('ordenes'));
}

    public function indexShow($id){
  
     $contrato = contract::find($id);

     return view('reports.show-contrato')->with('contrato', $contrato);
    }

    public function comisiones()
    {
        $user = Auth::user();

        if($user->admin == 1){
            $comisiones = Wallet::orderBy('id', 'desc')->where('type', 1)->get();
        }else{
            $comisiones = Wallet::orderBy('id', 'desc')->where('type', 1)->where('user_id', $user->id)->get();
        }

        return view('reports.comisiones', compact('comisiones'));
    }
}

