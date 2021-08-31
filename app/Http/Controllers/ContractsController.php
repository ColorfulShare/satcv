<?php

namespace App\Http\Controllers;

use App\Models\contract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\OrdenPurchases;
use Hexters\CoinPayment\CoinPayment;
use App\Models\Log_utility;
use App\Models\Wallet;
use DB;
use App\Models\Utility;

class contractsController extends Controller
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
                'type_interes' => $orden->type_interes
            ];
            Contract::create($data);
    
        } catch (\Throwable $th) {
            Log::error('contractsController - saveContrato -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    public function removeContract(Request $request)
    {
        $contract = Contract::findOrFail($request->contratoId);
        $contract->status = 2;
        $contract->capital = $contract->capital - ($contract->capital * 0.25 );
        $contract->save();

        return response()->json(true);
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
        try{
            $contratos = Contract::all();
            return $contratos;
        } catch (\Throwable $th) {
            Log::error('Dashboard - getContrato -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }


    public function contratosUser()
    {
        $contratos = $this->contratos();
        return view('contract.user', compact('contratos'));
    }

    /**
     * Lleva a la vista de inversion
     */
    public function inversion()
    {
        $contratos = $this->contratos();
        return view('contract.inversion', compact('contratos'));
    }

     /**
     * Lleva a la vista de utilidades
     */
    public function utilidades()
    {
        $utilitys = Utility::orderBy('id', 'desc')->get();

        return view('contract.utilidades', compact('utilitys'));
    }

    public function payUtility(Request $request)
    {
        $validate = $request->validate([
            'porcentaje' => 'required',
            'mes' => 'required'
        ]);

        try {
            if ($validate){
                DB::beginTransaction();
                $porcentaje = $request->porcentaje / 100;
                $ids = [];
                $gain = 0;
                $contratos = Contract::where('status', 1)->get();
            
                foreach($contratos as $contrato){
                    
                    $wallet = null;
                    $previoues_capital = $contrato->capital;
                    if($contrato->type_interes == "lineal"){
                        $wallet = new Wallet;
                        $wallet->user_id = $contrato->user()->id;
                        $wallet->amount = $contrato->capital * $porcentaje;
                        $wallet->percentage = $porcentaje;
                        $wallet->descripcion = "Utilidad mensual";
                        $wallet->tipo_transaction = 1;
                        $wallet->save();

                        $gain+= $contrato->capital * $porcentaje;
                    }else{
                        $gain+= $contrato->capital * $porcentaje;
                        $contrato->capital += $contrato->capital * $porcentaje;
                        $contrato->save();
                    }
                    $current_capital = $contrato->capital;

                    $utility = new Log_utility;
                    $utility->contract_id = $contrato->id;
                    $utility->wallet_id = $wallet != null ? $wallet->id : null;
                    $utility->percentage = $porcentaje;
                    $utility->month = $request->mes;
                    $utility->year = Carbon::now()->format('Y');
                    $utility->previoues_capital = $previoues_capital;
                    $utility->current_capital = $current_capital;
                    $utility->save();
                    
                    $ids[] = $utility->id;
                    
                }

                $utilidad = new Utility;
                $utilidad->gain = $gain;
                $utilidad->percentage = $porcentaje;
                $utilidad->month = $request->mes;
                $utilidad->save();

                $utilidades = Log_utility::whereIn('id', $ids)->update(['utility_id' => $utilidad->id]);
            }
            DB::commit();
            return back()->with('success', 'Utilidad pagada exitosamente');
        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('contractsController - payUtility -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }
}
