<?php

namespace App\Http\Controllers;

use Datatables;
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

    /**
     * Permite listar todos los contratos generadas
     * @return collection
     */
    public function contratos()
    {
        try{
            $contratos = Contract::where('status', 1)->orderBy('id', 'desc')->get();
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
        return view('contract.utilidades');
    }

    /**
     * Datatable dinámico (ServerSide) que se muestra en audit.rangos 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function dataInversion(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->contratos();
            return Datatables::of($data)
                ->addColumn('id', function($data){
                    return $data->id;
                })
                ->addColumn('nombre', function($data){
                    return $data->getOrden->user->name;
                })
                ->addColumn('documento', function($data){
                    return $data->getOrden->user->dni;
                })
                ->addColumn('correo', function($data){
                    return $data->getOrden->user->email;
                })
                ->addColumn('fecha', function($data){
                    return $data->created_at->format('Y/m/d');
                })
                ->addColumn('accion', function($data){
                    return '<div class="d-flex">
                        <a href="'. route('users.show-user', $data->getOrden->user->id) .'" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Ver Perfil">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button class="btn btn-info mx-1" data-toggle="tooltip" data-placement="top" title="Reenviar Contrato">
                            <i class="fa fa-paper-plane"></i>
                        </button>
                        <button class="btn btn-success"  data-toggle="tooltip" data-placement="right" title="Aprobar">
                            <i class="fa fa-check-square"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['accion'])
                ->make(true);
        }
    }
}
