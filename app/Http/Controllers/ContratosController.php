<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContratosController extends Controller
{
    //
    public function index(Request $request)
    {

        return view('contratos.index');
    }
}
