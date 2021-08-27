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
        return view('contract.index');
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
}
