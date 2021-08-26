<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    //
    public function index_retiros()
    {
        $user = Auth::user();
        $contratos = [];
        if(isset($user->contracts)){
            $contratos = $user->contracts->where('status', 1);
        }
    
        return view('retiros.index', compact('contratos'));
    }
}
