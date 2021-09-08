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

class TiendaController extends Controller
{

    public $apis_key_nowpayments;
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
        $transaction['redirect_url'] = url('/'); // When Transaction was comleted
        $transaction['cancel_url'] = url('/'); // When user click cancel link
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
           /*
            $headers = [
                'x-api-key: '.$this->apis_key_nowpayments,
                'Content-Type:application/json'
            ];

            $resul = ''; 
            $curl = curl_init();

            $dataRaw = collect([
                'price_amount' => floatval($data['total']),
                "price_currency" => "usd",
                "order_id" => $data['idorden'],
                'pay_currency' => 'USDTTRC20',
                //"order_description" => $data['descripcion'],
                "ipn_callback_url" => route('shop.ipn'),
                "success_url" => route('shop.proceso.status', [$data['idorden'], 'Completada']),
                "cancel_url" => route('shop.proceso.status', [$data['idorden'], 'Cancelada']),
            ]);
            

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.nowpayments.io/v1/invoice",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $dataRaw->toJson(),
                CURLOPT_HTTPHEADER => $headers
            ));
                
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                if ($err) {
                    Log::error('Tienda - generalUrlOrden -> Error curl: '.$err);        
                } else {
                    $response = json_decode($response);
                    OrdenPurchases::where('id', $data['idorden'])->update(['idtransacion' => $response->id]);
                    $resul = $response->invoice_url;
                }
                  
            return $resul;
            */
        } catch (\Throwable $th) {
            Log::error('Tienda - generalUrlOrden -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    public function cambiar_status(Request $request)
    {
        $orden = OrdenPurchases::findOrFail($request->id);
        $orden->status = $request->status;
        $orden->save();

        $this->registeContract($orden);

        $user = User::findOrFail($orden->user_id);
        $user->status = '1';
        $user->save();

        return back()->with('success', 'Orden actualizada exitosamente');
    }
}
