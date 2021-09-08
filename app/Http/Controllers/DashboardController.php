<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

  public $contratos;
  public $utilities;
  /**
     * Lleva a a la vista del dashboard
     */
  public function index(Request $request)
  {
      $this->contratos = new ContractsController;
      $contratos = $this->contratos->contratos();
      $utilities = $this->contratos->getUtilities()->take(6);
      return view('/content/dashboard/dashboard-analytics', compact('contratos', 'utilities'));
  }


}
