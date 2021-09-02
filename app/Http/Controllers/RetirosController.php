<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetirosController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('google_authenticator')->only('retirar');
    }
    public function retirar()
    {
        $user = Auth::user();

        return view('retiros.retirar', compact('user'));
    }
}
