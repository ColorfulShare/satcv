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
    $this->contratos = new contractsController;
    $contratos = $this->contratos->contratos();
    $utilities = $this->contratos->getUtilities()->take(6);
    return view('/content/dashboard/dashboard-analytics', compact('contratos', 'utilities'));
  }


}
