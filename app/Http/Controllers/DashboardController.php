<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{

  public $contratos;
  public $utilities;
  /**
     * Lleva a a la vista del dashboard
     */
  public function index($id = null)
  {
      $this->contratos = new ContractsController;
      $contratos = $this->contratos->contratos();
      $utilities = $this->contratos->getUtilities()->take(6);
    if(isset($id)){
      return view('/content/dashboard/dashboard-analytics', compact('contratos', 'utilities', 'id'));
    }else{
      return view('/content/dashboard/dashboard-analytics', compact('contratos', 'utilities'));
    }
  }


}
