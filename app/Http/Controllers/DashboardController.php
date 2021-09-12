<?php

namespace App\Http\Controllers;

use App\Models\User;
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

  public function indexAdmin(Request $request)
  {
      $this->contratos = new ContractsController;
      $contratos = $this->contratos->contratos();
      $utilities = $this->contratos->getUtilities();
      return view('/content/dashboard/dashboard-admin', compact('contratos', 'utilities'));
  }
  public function dashboard2($id)
  {
    $user = User::where('id',$id)->first();
    $this->contratos = new ContractsController;
    $contratos = $this->contratos->contracts($id);
    $utilities = $this->contratos->getUtilities()->take(6);
    return view('/content/dashboard/index', compact('user', 'contratos', 'utilities'));
  }

}
