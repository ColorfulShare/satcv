<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\OrdenPurchases;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
  // Dashboard - Analytics
  public function index()
  {
    $pageConfigs = ['pageHeader' => false];
    $ordenes = $this->contratos();

    return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs, 'ordenes' => $ordenes]);
  }

  public function contratos()
  {
    $user = auth()->user();
      if($user->admin == 1){
          $ordenes = OrdenPurchases::orderBy('id', 'desc')->get();
      }else{
          $ordenes = OrdenPurchases::orderBy('id', 'desc')->where('user_id', $user->id)->get();
      }
      return $ordenes;
  }

  public function getContrato($id)
  {
		try{
			$contrato = Contract::find($id);
			return json_encode($contrato);
		} catch (\Throwable $th) {
		Log::error('Dashboard - getContrato -> Error: '.$th);
		abort(403, "Ocurrio un error, contacte con el administrador");
		}
  }

}
