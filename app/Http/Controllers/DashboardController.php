<?php

namespace App\Http\Controllers;


class DashboardController extends Controller
{

  public $contratos;
  /**
     * Lleva a a la vista del dashboard
     */
  public function index()
  {
    $pageConfigs = ['pageHeader' => false];
    $this->contratos = new contractsController;
    $contratos = $this->contratos->contratos();

    return view('/content/dashboard/dashboard-analytics', ['pageConfigs' => $pageConfigs, 'contratos' => $contratos]);
  }


}
