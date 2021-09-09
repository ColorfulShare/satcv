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

    public function index()
    {
        $contratos = $this->contratos();
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
            $capital = $solicitud->amount - ($solicitud->amount * 0.25);

            $Contract = Contract::findOrFail($request->contratoId);
            // $Contract->capital -= $capital;
            if($Contract->capital <= 0){
                $Contract->status = 2;
            }

            $Contract->save();

            $solicitud->update(['status' => 1, 'wallet' => $request->wallet]);
            
            Liquidation::create([
                'user_id' => $Contract->user()->id,
                'amount' => $solicitud->amount,
                'total_amount' => $capital,
                'feed' => $solicitud->amount * 0.25,
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

    public function testCoin()
    {
        $transaction['order_id'] = uniqid(); // invoice number
        $transaction['amountTotal'] = (FLOAT) 37.5;
        $transaction['note'] = 'Transaction note';
        $transaction['buyer_name'] = 'Jhone Due';
        $transaction['buyer_email'] = 'buyer@mail.com';
        $transaction['redirect_url'] = url('/back_to_tarnsaction'); // When Transaction was comleted
        $transaction['cancel_url'] = url('/back_to_tarnsaction'); // When user click cancel link
        /*
        *   @required true
        *   @example first item
        */
        $transaction['items'][] = [
            'itemDescription' => 'Product one',
            'itemPrice' => (FLOAT) 7.5, // USD
            'itemQty' => (INT) 1,
            'itemSubtotalAmount' => (FLOAT) 7.5 // USD
        ];
        /*
        *   @example second item
        */
        $transaction['items'][] = [
            'itemDescription' => 'Product two',
            'itemPrice' => (FLOAT) 10, // USD
            'itemQty' => (INT) 1,
            'itemSubtotalAmount' => (FLOAT) 10 // USD
        ];
        /*@example third item*/
        $transaction['items'][] = [
            'itemDescription' => 'Product Three',
            'itemPrice' => (FLOAT) 10, // USD
            'itemQty' => (INT) 2,
            'itemSubtotalAmount' => (FLOAT) 20 // USD
        ];
        $transaction['payload'] = [
            'foo' => [
                'bar' => 'baz'
            ]
        ];     
        $ruta = CoinPayment::generatelink($transaction);

        return redirect($ruta);
    }

    /**
     * Permite listar todos los contratos generadas
     * @return collection
     */
    public function contratos()
    {
        // dd( $contratos);
        try{
            $user = auth()->user();
            if($user->admin == 1){
                $contratos = Contract::orderBy('id', 'asc')->get();
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
        $utilities = Utility::orderBy('id', 'desc')->get();
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
                //$porcentaje = $request->porcentaje / 100;
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
                $data->mes = array_column($data->utilidades, 'month');
                return response()->json($data);
            } catch (\Throwable $th) {
            Log::error('ContractsController::getContrato -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
            }
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
}
