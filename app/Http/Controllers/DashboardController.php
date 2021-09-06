<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{

  public $contratos;
  public $utilities;
  /**
     * Lleva a a la vista del dashboard
     */
  public function index()
  {
    $this->contratos = new ContractsController;
    $contratos = $this->contratos->contratos();
    $utilities = $this->contratos->getUtilities();
    return view('/content/dashboard/dashboard-analytics', compact('contratos', 'utilities'));
  }


}
