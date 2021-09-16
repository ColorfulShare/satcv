<?php

namespace App\Http\Controllers;

use DB;
use stdClass;
use Datatables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Utility;
use App\Models\Contract;
use App\Models\Liquidation;
use App\Models\Log_utility;
use Illuminate\Http\Request;
use App\Models\OrdenPurchases;
use App\Models\SolicitudRetiro;
use Illuminate\Support\Facades\Log;
use Hexters\CoinPayment\CoinPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;

class ContractsController extends Controller
{
    /**
     * Lleva a a la vista de las inversiones
     *
     * @param [type] $tipo
     * @return void
     */
    public function __construct()
    {
    
    }

    public function index(Request $request)
    {
        $contratos = $this->contratos($request->id);
        return view('contract.index', compact('contratos'));
    }
    /**
     * Permite guardar las nuevas contratos generadas
     *
     * @param integer $paquete - ID del Paquete Comprado
     * @param integer $orden - ID de la compra Comprada
     * @param float $invertido - Monto Total Invertido
     * @param string $vencimiento - Fecha de Vencimiento del paquete
     * @param integer $iduser - ID del usuario 
     * @return void
     */
    public function saveContrato($orden)
    {
        try {
            $data = [
                'orden_purchases_id' => $orden->id,
                'user_id' => $orden->user_id,
                'invested' => $orden->amount,
                'capital' => $orden->amount,
                'type_interes' => $orden->type_interes,
                'firma_cliente' => $orden->firma_cliente
            ];
            Contract::create($data);
    
        } catch (\Throwable $th) {
            Log::error('ContractsController - saveContrato -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    public function removeContract(Request $request)
    {
        try{
            DB::beginTransaction();
            $solicitud = SolicitudRetiro::find($request->solicitudId);
            $capital = $solicitud->amount - ($solicitud->amount * 0.20);

            $Contract = Contract::findOrFail($request->contratoId);
            // $Contract->capital -= $capital;
            if($Contract->capital <= 0){
                $Contract->status = 2;
            }

            $Contract->save();
        
            $solicitud->update(['status' => 1, 'wallet' => $request->wallet]);
            
            Liquidation::create([
                'user_id' => $Contract->user()->id,
                'contract_id' => $Contract->id,
                'amount' => $solicitud->amount,
                'total_amount' => $capital,
                'feed' => $solicitud->amount * 0.20,
                'percentage' => 0.20,
                'wallet_used' => $request->wallet,
                'status' => 0,
                'type' => 0
            ]);

            DB::commit();
            return response()->json(true);
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('ContractsController - removeContract -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }   

    /**
     * Permite listar todos los contratos generadas
     * @return collection
     */
    public function contratos($id = null)
    {
        try{
            $user = auth()->user();
            if($user->admin == 1){
                if($id == null){
                    $contratos = Contract::orderBy('id', 'desc')->get();
                }else{
                    $contratos = collect();
                    $users = User::where('referred_id', $id)->get();
                    foreach($users as $user){
                        
                        foreach($user->contracts as $contrato){
                            $contratos->push($contrato);
                        }
                    }
                }
    
            }else{
                $contratos = $user->Contracts->sortBy('id');
            }
            return $contratos;
        } catch (\Throwable $th) {
            Log::error('ContractsController::contratos -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    public function contracts($id)
    {
        // dd( $contratos);
        try{
            $user = User::where('id',$id)->first();
            if($user->admin == 1){
                $contratos = Contract::orderBy('id', 'asc')->get();
            }else{
                $contratos = $user->Contracts->sortBy('id');
            }
            return $contratos;
        } catch (\Throwable $th) {
            Log::error('ContractsController::contracts -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }


    public function contratosUser()
    {
        $contratos = $this->contratos();
        return view('contract.user', compact('contratos'));
    }

     /**
     * Lleva a la vista de utilidades
     */
    public function utilidades()
    {
        $utilities = $this->getUtilities();
        return view('contract.utilidades', compact('utilities'));
    }

    public function getUtilities()
    {
        $utilities = Utility::orderBy('id', 'desc')->where('type', 0)->get();
        return $utilities;
    }

    public function payUtility(Request $request)
    {
        $validate = $request->validate([
            'porcentaje' => 'required',
            'mes' => 'required'
        ]);

        $fecha = Carbon::parse($request->mes);
        
        try {
            if ($validate){
                DB::beginTransaction();
                $porcentaje = $request->porcentaje / 100;
                $ids = [];
                $gain = 0;
                
                $contratos = Contract::where('status', 1)->whereHas('getOrden.user', function($user)use($ids){
                    $user->where('type', 0)->where('referred_id', null);
                })->get();
            
                foreach($contratos as $contrato){
                    //SACO EL PORCENTAJE
                    
                    if($fecha->format('Y') == $contrato->created_at->format('Y') && $fecha->format('m') == $contrato->created_at->format('m') && intval($contrato->created_at->format('d')) > 1){
                        $resta = 30 - (intval($contrato->created_at->format('d')) + 1);
                        $porcentaje = ($resta * ($request->porcentaje / 100) ) / 30;
                        
                    }
                    
                    $wallet = null;
                    $previoues_capital = $contrato->capital;
                    if($contrato->type_interes == "lineal"){
                        $wallet = new Wallet;
                        $wallet->user_id = $contrato->user()->id;
                        $wallet->contract_id = $contrato->id;
                        $wallet->amount = $contrato->capital * $porcentaje;
                        $wallet->percentage = $porcentaje;
                        $wallet->descripcion = "Utilidad mensual";
                        $wallet->payment_date = $request->mes;
                        $wallet->save();

                        $gain+= $contrato->capital * $porcentaje;
                        $contrato->gain += $contrato->capital * $porcentaje;
                        $contrato->save();
                    }else{
                        $wallet = new Wallet;
                        $wallet->user_id = $contrato->user()->id;
                        $wallet->contract_id = $contrato->id;
                        $wallet->amount = $contrato->capital * $porcentaje;
                        $wallet->percentage = $porcentaje;
                        $wallet->descripcion = "Utilidad mensual";
                        $wallet->payment_date = $request->mes;
                        $wallet->status = 3;
                        $wallet->save();
                        
                        $gain+= $contrato->capital * $porcentaje;
                        $contrato->gain += $contrato->capital * $porcentaje;
                        $contrato->capital += $contrato->capital * $porcentaje;
                        $contrato->save();
                    }
                    $current_capital = $contrato->capital;

                    $utility = new Log_utility;
                    $utility->Contract_id = $contrato->id;
                    $utility->wallet_id = $wallet != null ? $wallet->id : null;
                    $utility->percentage = $porcentaje;
                    $utility->amount = $wallet->amount;
                    $utility->payment_date = $request->mes;
                    $utility->previoues_capital = $previoues_capital;
                    $utility->current_capital = $current_capital;
                    $utility->save();
                    
                    $ids[] = $utility->id;
                    
                }

                $utilidad = new Utility;
                $utilidad->gain = $gain;
                $utilidad->percentage = $request->porcentaje;
                $utilidad->payment_date = $request->mes;
                $utilidad->save();

                $utilidades = Log_utility::whereIn('id', $ids)->update(['utility_id' => $utilidad->id]);
            }
            DB::commit();
            return back()->with('success', 'Utilidad pagada exitosamente');
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('ContractsController - payUtility -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    public function payUtilityCartera(Request $request)
    {
        $validate = $request->validate([
            'porcentaje_administrador' => 'required',
            'porcentaje_cartera' => 'required',
            'mes' => 'required'
        ]);

        $fecha = Carbon::parse($request->mes);
        
        try {
            if ($validate){
                DB::beginTransaction();
                $ids = [];
                //COMISION

                $porcentaje = ($request->porcentaje_administrador - $request->porcentaje_cartera) / 100;
                
                $referidos = Contract::where('status', 1)->whereHas('getOrden.user', function($user){
                    $user->where('referred_id', '<>' ,null);
                })->get();
                
                if(count($referidos) > 0){
                    foreach($referidos as $contrato){
                        //SACO EL PORCENTAJE
                        
                        if($fecha->format('Y') == $contrato->created_at->format('Y') && $fecha->format('m') == $contrato->created_at->format('m') && intval($contrato->created_at->format('d')) > 1){
                            $resta = 30 - (intval($contrato->created_at->format('d')) + 1);
                            $porcentaje = ($resta * ( ($request->porcentaje_administrador - $request->porcentaje_cartera) / 100) ) / 30;
                            
                        }
                        
                        $wallet = null;
                        $previoues_capital = $contrato->capital;
                        if($contrato->type_interes == "lineal"){
                            $wallet = new Wallet;
                            $wallet->user_id = $contrato->user()->referred_id;
                            $wallet->contract_id = $contrato->id;
                            $wallet->amount = $contrato->capital * $porcentaje;
                            $wallet->percentage = $porcentaje;
                            $wallet->descripcion = "Utilidad mensual";
                            $wallet->payment_date = $request->mes;
                            $wallet->type = 1;
                            $wallet->save();

                        }else{
                            $wallet = new Wallet;
                            $wallet->user_id = $contrato->user()->referred_id;
                            $wallet->contract_id = $contrato->id;
                            $wallet->amount = $contrato->capital * $porcentaje;
                            $wallet->percentage = $porcentaje;
                            $wallet->descripcion = "Utilidad mensual";
                            $wallet->payment_date = $request->mes;
                            $wallet->status = 3;
                            $wallet->type = 1;
                            $wallet->save();
                        }
                        $current_capital = $contrato->capital;

                        $utility = new Log_utility;
                        $utility->Contract_id = $contrato->id;
                        $utility->wallet_id = $wallet != null ? $wallet->id : null;
                        $utility->percentage = $porcentaje;
                        $utility->amount = $wallet->amount;
                        $utility->payment_date = $request->mes;
                        $utility->previoues_capital = $previoues_capital;
                        $utility->current_capital = $current_capital;
                        $utility->save();
                        
                        $ids[] = $utility->id;
                        
                    }
                    
                }
                //administradores

                $gain = 0;
                
                $porcentaje = $request->porcentaje_administrador / 100;

                $administradores = Contract::where('status', 1)->whereHas('getOrden.user', function($user){
                    $user->where('type', 1);
                })->get();
                
                if(count($administradores) > 0){
                    foreach($administradores as $contrato){
                        //SACO EL PORCENTAJE
                        
                        if($fecha->format('Y') == $contrato->created_at->format('Y') && $fecha->format('m') == $contrato->created_at->format('m') && intval($contrato->created_at->format('d')) > 1){
                            $resta = 30 - (intval($contrato->created_at->format('d')) + 1);
                            $porcentaje = ($resta * ($request->porcentaje_administrador / 100) ) / 30;
                            
                        }
                        
                        $wallet = null;
                        $previoues_capital = $contrato->capital;
                        if($contrato->type_interes == "lineal"){
                            $wallet = new Wallet;
                            $wallet->user_id = $contrato->user()->id;
                            $wallet->contract_id = $contrato->id;
                            $wallet->amount = $contrato->capital * $porcentaje;
                            $wallet->percentage = $porcentaje;
                            $wallet->descripcion = "Utilidad mensual";
                            $wallet->payment_date = $request->mes;
                            $wallet->save();

                            $gain+= $contrato->capital * $porcentaje;
                            $contrato->gain += $contrato->capital * $porcentaje;
                            $contrato->save();
                        }else{
                            $wallet = new Wallet;
                            $wallet->user_id = $contrato->user()->id;
                            $wallet->contract_id = $contrato->id;
                            $wallet->amount = $contrato->capital * $porcentaje;
                            $wallet->percentage = $porcentaje;
                            $wallet->descripcion = "Utilidad mensual";
                            $wallet->payment_date = $request->mes;
                            $wallet->status = 3;
                            $wallet->save();
                            
                            $gain+= $contrato->capital * $porcentaje;
                            $contrato->gain += $contrato->capital * $porcentaje;
                            $contrato->capital += $contrato->capital * $porcentaje;
                            $contrato->save();
                        }
                        $current_capital = $contrato->capital;

                        $utility = new Log_utility;
                        $utility->Contract_id = $contrato->id;
                        $utility->wallet_id = $wallet != null ? $wallet->id : null;
                        $utility->percentage = $porcentaje;
                        $utility->amount = $wallet->amount;
                        $utility->payment_date = $request->mes;
                        $utility->previoues_capital = $previoues_capital;
                        $utility->current_capital = $current_capital;
                        $utility->save();
                        
                        $ids[] = $utility->id;
                        
                    }
                }
                //REFERIDOS

                $gain2 = 0;
                $porcentaje = $request->porcentaje_cartera / 100;

                $referidos = Contract::where('status', 1)->whereHas('getOrden.user', function($user){
                    $user->where('referred_id', '<>' ,null);
                })->get();
                
                if(count($referidos) > 0){
                    foreach($referidos as $contrato){
                        //SACO EL PORCENTAJE
                        
                         if($fecha->format('Y') == $contrato->created_at->format('Y') && $fecha->format('m') == $contrato->created_at->format('m') && intval($contrato->created_at->format('d')) > 1){
                            $resta = 30 - (intval($contrato->created_at->format('d')) + 1);
                            $porcentaje = ($resta * ($request->porcentaje_cartera / 100) ) / 30;
                            
                        }
                        
                        $wallet = null;
                        $previoues_capital = $contrato->capital;
                        if($contrato->type_interes == "lineal"){
                            $wallet = new Wallet;
                            $wallet->user_id = $contrato->user()->id;
                            $wallet->contract_id = $contrato->id;
                            $wallet->amount = $contrato->capital * $porcentaje;
                            $wallet->percentage = $porcentaje;
                            $wallet->descripcion = "Utilidad mensual";
                            $wallet->payment_date = $request->mes;
                            $wallet->save();

                            $gain2+= $contrato->capital * $porcentaje;
                            $contrato->gain += $contrato->capital * $porcentaje;
                            $contrato->save();
                        }else{
                            $wallet = new Wallet;
                            $wallet->user_id = $contrato->user()->id;
                            $wallet->contract_id = $contrato->id;
                            $wallet->amount = $contrato->capital * $porcentaje;
                            $wallet->percentage = $porcentaje;
                            $wallet->descripcion = "Utilidad mensual";
                            $wallet->payment_date = $request->mes;
                            $wallet->status = 3;
                            $wallet->save();
                            
                            $gain2+= $contrato->capital * $porcentaje;
                            $contrato->gain += $contrato->capital * $porcentaje;
                            $contrato->capital += $contrato->capital * $porcentaje;
                            $contrato->save();
                        }
                        $current_capital = $contrato->capital;

                        $utility = new Log_utility;
                        $utility->Contract_id = $contrato->id;
                        $utility->wallet_id = $wallet != null ? $wallet->id : null;
                        $utility->percentage = $porcentaje;
                        $utility->amount = $wallet->amount;
                        $utility->payment_date = $request->mes;
                        $utility->previoues_capital = $previoues_capital;
                        $utility->current_capital = $current_capital;
                        $utility->save();
                        
                        $ids[] = $utility->id;
                        
                    }

                    

                }
                $utilidad = new Utility;
                $utilidad->gain_cartera = $gain2;
                $utilidad->percentage_cartera = $request->porcentaje_cartera;
                $utilidad->payment_date = $request->mes;
                $utilidad->type = 1;
                $utilidad->gain = $gain;
                $utilidad->percentage = $request->porcentaje_administrador;
                $utilidad->save();
            
                $utilidades = Log_utility::whereIn('id', $ids)->update(['utility_id' => $utilidad->id]);
            }
            
            DB::commit();
            return back()->with('success', 'Utilidad pagada exitosamente');
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('ContractsController - payUtility -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    /**
     * Retorna todos los contratos para el admin
     * 
     * @return json
     */
    public function contractsAdmin()
    {
        // try{
            $data = new stdClass();
            $date = Carbon::now();
            $from = $date->subYear()->format('Y-m-d')." 00:00:00";

            $lineal = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ];
            $compuesto = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ];
            /* Realizamos la consulta */
            $inversionLineal = Contract::where('type_interes', 'lineal')
            ->whereBetween('created_at',[$from,\Carbon\Carbon::now()->format('Y-m-d')])->select(DB::raw('count(*) as contratos'), DB::raw("DATE_FORMAT(created_at,'%m') as mes"))->groupBy('mes')->get();
            /* Iteramos cada registro del resultado */
            foreach($inversionLineal as $registro) {
                /* Rellenamos el mes adecuado de la matriz */
                $lineal[intval($registro->mes) - 1] = $registro->contratos;
            }

            $inversionCompuesto = Contract::where('type_interes', 'compuesto')->whereBetween('created_at', [$from, \Carbon\Carbon::now()->format('Y-m-d')])->select(DB::raw('count(*) as contratos'),DB::raw("DATE_FORMAT(created_at,'%m') as mes"))->groupBy('mes')->get();

            foreach($inversionCompuesto as $registro) {
                $compuesto[intval($registro->mes) - 1] = $registro->contratos;
            }
            $data->lineal = $lineal;
            $data->compuesto =  $compuesto;
            $linealPorcentaje = [];
            $compuestoPorcentaje = [];
            foreach ($lineal as $key => $value) {
                $total = ($lineal[$key] == 0 || $compuesto[$key] == 0) ? 1 : $lineal[$key] + $compuesto[$key];
                $linealPorcentaje[] += ($lineal[$key] / $total) * 100;
                $compuestoPorcentaje[] += ($compuesto[$key] / $total) * 100;
            }
            $data->linealPorcentaje = $linealPorcentaje;
            $data->compuestoPorcentaje = $compuestoPorcentaje;


            $linealEntradas = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ];

            $linealEntrada = Contract::where('type_interes', 'lineal')
            ->whereBetween('created_at',[$from,\Carbon\Carbon::now()->format('Y-m-d')])->select(DB::raw('sum(invested) as entradas'), DB::raw("DATE_FORMAT(created_at,'%m') as mes"))->groupBy('mes')->get();
            foreach($linealEntrada as $registro) {
                /* Rellenamos el mes adecuado de la matriz */
                $linealEntradas[intval($registro->mes) - 1] = $registro->entradas;
            }

            $compuestoEntradas = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ];

            $compuestoEntrada = Contract::where('type_interes', 'compuesto')
            ->whereBetween('created_at',[$from,\Carbon\Carbon::now()->format('Y-m-d')])->select(DB::raw('sum(invested) as entradas'), DB::raw("DATE_FORMAT(created_at,'%m') as mes"))->groupBy('mes')->get();
            foreach($compuestoEntrada as $registro) {
                /* Rellenamos el mes adecuado de la matriz */
                $compuestoEntradas[intval($registro->mes) - 1] = $registro->entradas;
            }

            $data->linealEntradas = $linealEntradas;
            $data->compuestoEntradas = $compuestoEntradas;


            // $linealUtility = Log_utility::
            // whereBetween('log_utilities.created_at',[$from,\Carbon\Carbon::now()->format('Y-m-d')])
            // ->where('wallets.type', '=', '0')
            // ->join('contracts', 'log_utilities.id', 'contracts.id')
            // ->join('wallets', 'log_utilities.id', 'wallets.id')
            // ->select(DB::raw('sum(log_utilities.amount) as lineal'), 
            // DB::raw("DATE_FORMAT(log_utilities.created_at,'%m') as mes"))
            // ->groupBy('mes')
            // ->get()
            // ->toArray();

            $raw = Log_utility::join('contracts', 'contracts.id', 'log_utilities.id')
            ->select(
                DB::raw("DATE_FORMAT(log_utilities.created_at,'%m') as mes"),
                DB::raw('sum(case when contracts.type_interes = "lineal" then amount end) as lineal'), 
                DB::raw('sum(case when contracts.type_interes = "compuesto" then amount end) as compuesto'),     
                )
                ->groupBy('mes')
                ->whereBetween('log_utilities.created_at',[$from,\Carbon\Carbon::now()->format('Y-m-d')])
                ->whereHas('wallet', function($wallet){
                    $wallet->where('type', 0);
                })
                ->get();
                
                $utilidadesLineales = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ];
                $utilidadesCompuestas = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ];
                foreach($raw as $registro) {
                    /* Rellenamos el mes adecuado de la matriz */
                    if($registro->lineal == null){
                        $registro->lineal = 0; 
                    }
                    if($registro->compuesto == null){
                        $registro->compuesto = 0; 
                    }
                    $utilidadesLineales[intval($registro->mes) - 1] = $registro->lineal;
                    $utilidadesCompuestas[intval($registro->mes) - 1] = $registro->compuesto;
                }
                // dd($utilidadesLineales, $utilidadesCompuestas);
                $total = array();

                for($i = 0; $i < count($utilidadesLineales); $i++) {
                    $total[] = $utilidadesLineales[$i] + $utilidadesCompuestas[$i];
                }
                
                $data->utilidadesTotales = $total;
                $data->utilidadesLineales = $utilidadesLineales;
                $data->utilidadesCompuestas = $utilidadesCompuestas;



                $capitales = Contract::
                select(
                    DB::raw('sum(case when type_interes = "lineal" then capital end) as lineal'), 
                    DB::raw('sum(case when type_interes = "compuesto" then capital end) as compuesto'),     
                    )
                    ->whereBetween('created_at',[$from,\Carbon\Carbon::now()->format('Y-m-d')])
                    ->first()->toArray();
                    $capitalesLineal = $capitales['lineal'];
                    $capitalesCompuesto = $capitales['compuesto']; 
                $data->capitalesLineal = $capitalesLineal;
                $data->capitalesCompuesto = $capitalesCompuesto;


                $capitalesMesesLineal = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ];
                $capitalesMesesCompuesto = [ 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 ];
                $capitalesMes = Contract::
                select(
                    DB::raw("DATE_FORMAT(created_at,'%m') as mes"),
                    DB::raw('sum(case when type_interes = "lineal" then capital end) as lineal'), 
                    DB::raw('sum(case when type_interes = "compuesto" then capital end) as compuesto'),     
                    )
                    ->groupBy('mes')
                    ->whereBetween('created_at',[$from,\Carbon\Carbon::now()->format('Y-m-d')])
                    ->get();
                    
                    foreach($capitalesMes as $registro) {
                        /* Rellenamos el mes adecuado de la matriz */
                        if($registro->lineal == null){
                            $registro->lineal = 0; 
                        }
                        if($registro->compuesto == null){
                            $registro->compuesto = 0; 
                        }
                        $capitalesMesesLineal[intval($registro->mes) - 1] = $registro->lineal;
                        $capitalesMesesCompuesto[intval($registro->mes) - 1] = $registro->compuesto;
                    }
                    
                    $data->capitalesMesesLineal = $capitalesMesesLineal;
                    $data->capitalesMesesCompuesto = $capitalesMesesCompuesto;
                    
            return response()->json($data);
        // } catch (\Throwable $th) {
        //     Log::error('ContractsController::getContrato -> Error: '.$th);
        //     abort(403, "Ocurrio un error, contacte con el administrador");
        // }
    }

    
      /**
     * Retorna el contrato según el id que se le pase
     *
     * @return json
     */
    public function getContrato($id)
    {
            try{
                $data = new stdClass();
                $contrato = Contract::find($id);
                if($contrato->productividad() != null){
                    $productividad = $contrato->productividad();
                }else{
                    $productividad = 0;
                }

                if($contrato->retirado() != null){
                    $retirado = $contrato->retirado();
                }else{
                    $retirado = 0;
                }
                
                
                $data->contrato = $contrato;
                $data->productividad = $productividad;
                $data->retirado = $retirado;
                $data->dias = ($contrato->countDaysContract() / 365) * 100;
                $utilities = $contrato->wallets()->orderByDesc('id')->latest()->take(6)->get()->toArray();
                sort($utilities);
                $data->utilidades = $utilities;
                $utility = $contrato->wallets()->select('id', 'payment_date', 'amount', 'percentage')->orderByDesc('id')->latest()->take(6)->get()->toArray();
                // dd($utility);
                $data->utility = $utility;
                $data->amount = array_column($data->utilidades, 'amount');
                $data->percentage = array_column($data->utilidades, 'percentage');
                $arraypositivo = [];
                $arraynegativo = [];
                foreach($data->percentage as $valores){
                    if($valores > 0){
                        $arraypositivo[]  = $valores;
                        $arraynegativo[]  = 0;
                    }else{ 
                        $arraypositivo[] = 0;
                        $arraynegativo[] = $valores;
                    }
                }
                $data->positivo = $arraypositivo;
                $data->negativo = $arraynegativo;
                foreach($data->utilidades as $i => $d){
                    $data->utilidades[$i]['payment_date'] = Carbon::create($d['payment_date'])->month;
                }

                $data->mes = array_column($data->utilidades, 'payment_date');
                $data->daysleft = $contrato->diffDaysExpiration();
                return response()->json($data);
            } catch (\Throwable $th) {
            Log::error('ContractsController::getContrato -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
            }
    }

     /**
     * Retorna las inversiones según el id del usuario
     *
     * @return json
     */
    public function getInversion($id)
    {
        $data = new stdClass();
        $inversiones = User::find($id)->contracts()->get()->toArray();
        $data->invertido = array_column($inversiones, 'invested');
        $data->capital = array_column($inversiones, 'capital');
        $data->contratoid = array_column($inversiones, 'id');
        $data->gananciaArray = array_column($inversiones, 'gain');
        $data->ganancia = User::find($id)->ganancia();

        $contratos = User::find($id)->contracts()->get();
        $utilidades = collect();
        
        foreach($contratos as  $contrato){
            $utilidades->push($contrato->wallets);
        };
        $data->utilidades = $utilidades;
        return response()->json($data);
    }

    /**
     * Formulario para subir PDF
     *
     */
    public function formPdf(Request $request)
    {
        try{
            $validate = $request->validate([
                'idContract' => 'required',
                'urlpdf' => ['nullable', 'max:4096']
            ]);
            
            if($validate){      
                $file = $request->urlpdf;
                $nombre = time() . $file->getClientOriginalName();
                $ruta = 'pdf-Contract/' . $request->idContract . '/' . $nombre;
                $contrato = Contract::find($request->idContract);
                $contrato->url_pdf = $ruta;
                $contrato->save();
                $file->storeAs('public/pdf-Contract/'.$request->idContract, $nombre);
                return redirect()->back()->with('success', 'PDF Guardado Exitosamente');
            }   

        } catch (\Throwable $th) {
            Log::error('ContractsController::formPdf -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    public function generatePdf($id)
    {
        $contract = Contract::findOrFail($id);
        
        $pdf = PDF::loadView('contract.pdf', compact('contract'));

        //$pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->setPaper('A4', 'portrait');
        
        $html = $pdf->stream();
        //$html = $pdf->download('reporte-socios-'. Carbon::now()->format('d/m/Y').'.pdf');

        return $html;
    }    
    public function utilidadesCartera()
    {
        $utilities = Utility::orderBy('id', 'desc')->where('type', 1)->get();

        return view('contract.utilidadesCartera', compact('utilities'));
    }
}
