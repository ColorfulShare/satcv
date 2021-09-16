<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use App\Models\OrdenPurchases;
use App\Models\Packages;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ContractsController;
use Hexters\CoinPayment\CoinPayment;
use DB;

class TiendaController extends Controller
{
    public $ContractsController;

    public function __construct()
    {
        $this->ContractsController = new ContractsController();
    }

    /**
     * Permiete procesar la orden de compra
     *
     * @param Request $request
     * @return void
     */
    public function procesarOrden(Request $request)
    {
        
        $validate = $request->validate([
            'interes' => 'required',
            'monto' => 'required|numeric|min:500'
        ]);

        try {
            if(Auth::user()->verify != '1'){
                return redirect()->back()->with('danger', 'Su cuenta no ha sido verificada');
            }
            if ($validate) {

                $porcentaje = ($request->monto * 0.03);
                                
                $data = [
                    'user_id' => Auth::id(),
                    'amount' => $request->monto,
                    'fee' => $porcentaje,
                    'type_interes' => $request->interes,
                    'firma_cliente' => $request->imagen64
                ];

                $data['idorden'] = $this->saveOrden($data);
                $user = Auth::user();
                $data['name'] = $user->name ." ". $user->lastname;
                $data['email'] = $user->email;
                $data['total'] = $data['amount'] + $porcentaje;
                $data['descripcion'] = "Inversion contrato";
                
                $url = $this->generalUrlOrden($data);
                if (!empty($url)) {
                    return redirect($url);

                }else{
                    OrdenPurchases::where('id', $data['idorden'])->delete();
                    return redirect()->back()->with('msj-info', 'Problemas al general la orden, intente mas tarde');
                }
            }
        } catch (\Throwable $th) {
            Log::error('Tienda - procesarOrden -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    /**
     * Guarda la informacion de las ordenes nuevas 
     *
     * @param array $data
     * @return integer
     */
    public function saveOrden($data): int
    {
        $orden = OrdenPurchases::create($data);
        return $orden->id;
    }

    /**
     * Notifica el estado de la compra una vez realizada
     *
     * @param integer $orden
     * @param string $status
     * @return void
     */
    public function statusProcess($orden, $status)
    {
        $type = ($status == 'Completada') ? 'success' : 'danger';
        $msj = 'Compra '.$status;

        if ($status == 'Completada') {
            $this->Contrato($orden);
        }

        return redirect()->route('shop')->with('msj-'.$type, $msj);
    }

    /**
     * Permite Registrar las ordenes de forma manual
     *
     * @return void
     */
    /**
     * Permite llamar al funcion que registra los contrato
     *
     * @param integer $idorden
     * @return void
     */
    private function registeContract($orden)
    {
        $this->ContractsController->saveContrato($orden);
    }

    /**
     * Permite recibir el estado de las ordenes 
     *
     * @param Request $resquet
     * @return void
     */
    public function ipn(Request $resquet)
    { 
        Log::info('ipn prueba ->', $resquet);
    }

    /**
     * Permite general el url para pagar la compra
     *
     * @param array $data
     * @return string
     */
    private function generalUrlOrden($data): string
    {
       try {
        
        $transaction['order_id'] = $data['idorden']; // invoice number
        $transaction['amountTotal'] = floatval($data['total']);
        $transaction['note'] = $data['descripcion'];
        $transaction['buyer_name'] = $data['name'];
        $transaction['buyer_email'] = $data['email'];
        $transaction['redirect_url'] = route('reports.index'); // When Transaction was comleted
        $transaction['cancel_url'] = route('contract.user'); // When user click cancel link
        $transaction['items'][] = [
        'itemDescription' => 'contrato',
        'itemPrice' => (FLOAT) $data['total'], // USD
        'itemQty' => (INT) 1,
        'itemSubtotalAmount' => (FLOAT) $data['total'] // USD
        ];
        
        $ruta = CoinPayment::generatelink($transaction);
        
        if($ruta != null){
            return $ruta;
        }
        
        } catch (\Throwable $th) {
            Log::error('Tienda - generalUrlOrden -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    public function cambiar_status(Request $request)
    {
        try {
            DB::beginTransaction();

            $orden = OrdenPurchases::findOrFail($request->id);
            $orden->status = $request->status;
            $orden->save();

            $this->registeContract($orden);

            $user = User::findOrFail($orden->user_id);
            $user->status = '1';
            $user->save();

            DB::commit();

            return back()->with('success', 'Orden actualizada exitosamente');
        } catch (\Throwable $th) {

            DB::rollback();

            Log::error('Tienda - cambiar_status -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    public function getStatus()
    {
        $transacciones = CoinPayment::gettransactions()->select('txn_id', 'order_id')->where('status', 0)->get() ->toArray();
    
        foreach($transacciones as $transaccion){
            $estado = CoinPayment::getstatusbytxnid($transaccion['txn_id']);
            if($estado['status'] != 0){
                $this->change_status($transaccion['order_id'], $estado['status']);
            }

        }
        
    }

    public function change_status($id, $estado)
    {
        try {
            DB::beginTransaction();

            $orden = OrdenPurchases::findOrFail($id);
            if($estado < 0){
                $orden->status = 2;
                $orden->save();    
            }elseif($estado > 0){
                $this->registeContract($orden);

                $user = User::findOrFail($orden->user_id);
                $user->status = '1';
                $user->save();
            }
    
            DB::commit();

        } catch (\Throwable $th) {

            DB::rollback();

            Log::error('Tienda - change_status -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }
}
