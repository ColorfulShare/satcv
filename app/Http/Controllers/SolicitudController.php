<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\SolicitudRetiro;
use Illuminate\Support\Facades\Log;
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

    public function history()
    {
        if(Auth::user()->admin == 1){
            $retiros = SolicitudRetiro::orderBy('id', 'desc')->where('status', 1)->get();
        }else{
            $retiros = collect();
            $contracts = User::find(Auth::id())->contracts;
            foreach($contracts as $contrato){
                foreach($contrato->getHistory as $retiro){
                    $retiros->push($retiro);
                }
            }
        }
        return view('retiros.history', compact('retiros'));
    }

    public function solicitar(Request $request)
    {
        try{
            $contract = Contract::findOrFail($request->contratoId);

            $validate = $request->validate([
                'contratoId' => 'required',
                'amount' => 'required'
            ]);
            
            if ($validate) {
                $Contract = Contract::findOrFail($request->contratoId);
                $Contract->capital -= $request->amount;
                $Contract->save();
                $solicitud = SolicitudRetiro::create([
                    'contracts_id' => $request->contratoId,
                    'amount' => $request->amount,
                    'percentage' => 20,
                    'status' => 0
                ]);
                return response()->json(true);
            }

        } catch (\Throwable $th) {
            Log::error('SolicitudController - solicitar -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
  
    }

    public function index_solicitudes()
    {
        $solicitudes = SolicitudRetiro::orderBy('id', 'desc')->where('status', 0)->get();

        return view('retiros.solicitudes', compact('solicitudes'));
    }

    public function cancelar(Request $request)
    {
        SolicitudRetiro::find($request->solicitudId)->update(['status' => 2]);

        return response()->json(true);
    }
}
