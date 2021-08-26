<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenPurchases;

class DashboardController extends Controller
{
  // Dashboard - Analytics
  public function index()
  {
    $pageConfigs = ['pageHeader' => false];
    $ordenes = $this->getContratos();

    return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs, 'ordenes' => $ordenes]);
  }

  public function getContratos()
  {
    $user = auth()->user();
      if($user->admin == 1){
          $ordenes = OrdenPurchases::orderBy('id', 'desc')->get();
      }else{
          $ordenes = OrdenPurchases::orderBy('id', 'desc')->where('user_id', $user->id)->get();
      }
      return $ordenes;
  }

}
