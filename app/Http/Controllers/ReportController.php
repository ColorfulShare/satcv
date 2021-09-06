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
  
    public function indexOrders()
    {

    
      $ordenes = OrdenPurchases::orderBy('id', 'desc')->get();
               
    
        return view('reports.index', compact('ordenes'));
    }

    public function indexShow($id){
  
     $contrato = contract::find($id);
 

         return view('reports.show-contrato')->with('contrato', $contrato);

   }
}

