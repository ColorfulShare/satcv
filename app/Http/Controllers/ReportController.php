<?php

namespace App\Http\Controllers;

use App\Models\OrdenPurchases;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReportController extends Controller
{
    //

    /**
     * lleva a la vista de informen de pedidos
     *
     * @return void
     */
    public function indexPedidos()
    {
        $user = auth()->user();
        if($user->admin == 1){
            $ordenes = OrdenPurchases::orderBy('id', 'desc')->get();
        }else{
            $ordenes = OrdenPurchases::orderBy('id', 'desc')->where('user_id', $user->id)->get();
        }
        
    
        return view('reports.pedido', compact('ordenes'));
    }
}
