<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetirosController extends Controller
{
    //
    public function retirar()
    {
        $user = Auth::user();

        return view('retiros.retirar', compact('user'));
    }
}
