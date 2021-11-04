<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

  public $contratos;
  public $utilities;
  /**
     * Lleva a a la vista del dashboard
     */
  public function index(Request $request)
  {
    // dd($request->id);
    if(Auth::user()->admin != 1){
      
      $this->contratos = new ContractsController;
      $contratos = $this->contratos->contratos();
      $utilities = $this->contratos->getUtilities()->take(6);
      return view('/content/dashboard/dashboard-analytics', compact('contratos', 'utilities'));
    }else{
      
      if(isset($request->id)){
        $this->contratos = new ContractsController;
        $contratos = $this->contratos->contratos();
        $utilities = $this->contratos->getUtilities()->take(6);
        return view('/content/dashboard/dashboard-analytics', compact('contratos', 'utilities'));
      }else{
        $this->contratos = new ContractsController;
        $contratos = $this->contratos->contratos();
        $utilities = $this->contratos->getUtilities();
        return view('/content/dashboard/dashboard-admin', compact('contratos', 'utilities'));
      }
      
    }
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
