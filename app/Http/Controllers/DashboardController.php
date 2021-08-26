<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\OrdenPurchases;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
  /**
     * Lleva a a la vista del dashboard
     */
  public function index()
  {
    $pageConfigs = ['pageHeader' => false];
    $contratos = $this->contratos();

    return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs, 'contratos' => $contratos]);
  }

  /**
     * Retorna los datos de la tabla contracts
     *
     * @return collection
     */
  public function contratos()
  {
    $user = auth()->user();
      if($user->admin == 1){
          $contratos = Contract::orderBy('id', 'desc')->get();
      }else{
          $contratos = Contract::orderBy('id', 'desc')->where('user_id', $user->id)->get();
      }
      return $contratos;
  }

  /**
     * Retorna el contrato según el id que se le pase
     *
     * @return json
     */
  public function getContrato($id)
  {
		try{
			$contrato = Contract::find($id);
			return response()->json($contrato);
		} catch (\Throwable $th) {
		Log::error('Dashboard - getContrato -> Error: '.$th);
		abort(403, "Ocurrio un error, contacte con el administrador");
		}
  }

}
