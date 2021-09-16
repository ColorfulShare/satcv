<?php

namespace App\Http\Controllers;

use App\Models\Liquidation;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\Wallet;
use Illuminate\Support\Facades\Crypt;

class LiquidationController extends Controller
{
     /**
     * Permite aprobar las liquidaciones
     *
     * @param integer $idliquidation
     * @param string $billetera
     * @return string
     */
    public function aprovarLiquidacion($idliquidation, $billetera): string
    {
        
        $liquidation = Liquidation::find($idliquidation);
        // creo el arreglo de la transacion en coipayment
        $cmd = 'create_withdrawal';
        $result2 = '';
        $dataPago = [
            'amount' => $liquidation->total_amount,
            'currency' => 'USDT.TRC20',
            'address' => $billetera,
        ];
        // llamo la a la funcion que va a ser la transacion
        $result = $this->coinpayments_api_call($cmd, $dataPago);

        if (!empty($result['result'])) {
            Liquidation::where('id', $idliquidation)->update([
                'status' => 1,
                'hash' => $result['result']['id'],
                'wallet_used' => $billetera
            ]);

            Wallet::where('liquidation_id', $idliquidation)->update(['status' => 1]);   
        }else{
            $result2 = 'Error -> '.$result['error'];
            return back()->with('danger', $result['error']);
        }

        return $result2;
    }

    /**
	 * Funcion que hace el llamado a la api de coinpayment
	 * 	ojo: esto dejarlo tal cual, en coinpayment debe permitir este procedimiento "create_withdrawal"
	 *
	 * @param string $cmd - transacion a ejecutar
	 * @param array $req - arreglo con el request a procesar
	 * @return void
	 */
    public function coinpayments_api_call($cmd, $req = array())
    {
		// Fill these in from your API Keys page
		//$public_key = Crypt::decryptString(env('COINPAYMENT_PUBLIC_KEY', '32d8233ae79754bf42314170aa573863ef86f5218e211e50ed87b3e3f81c5094'));
		//$private_key = Crypt::decryptString(env('COINPAYMENT_PRIVATE_KEY', 'D09a0dc9Ad14Ce58453ab7852aBB3c3baa58E5E0f1965A55A8eE2925cd5d0388'));
		$public_key = env('COINPAYMENT_PUBLIC_KEY', '32d8233ae79754bf42314170aa573863ef86f5218e211e50ed87b3e3f81c5094');
        $private_key = env('COINPAYMENT_PRIVATE_KEY', 'D09a0dc9Ad14Ce58453ab7852aBB3c3baa58E5E0f1965A55A8eE2925cd5d0388');

		// Set the API command and required fields
		$req['version'] = 1;
		$req['cmd'] = $cmd;
		$req['key'] = $public_key;
		$req['format'] = 'json'; //supported values are json and xml
		
		// Generate the query string
		$post_data = http_build_query($req, '', '&');
		
		// Calculate the HMAC signature on the POST data
		$hmac = hash_hmac('sha512', $post_data, $private_key);
		
		// Create cURL handle and initialize (if needed)
		static $ch = NULL;
		if ($ch === NULL) {
			$ch = curl_init('https://www.coinpayments.net/api.php');
			curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		
		// Execute the call and close cURL handle     
		$data = curl_exec($ch);                
		// Parse and return data if successful.
		if ($data !== FALSE) {
			if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
				// We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
				$dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING);
			} else {
				$dec = json_decode($data, TRUE);
			}
			if ($dec !== NULL && count($dec)) {
				return $dec;
			} else {
				// If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
				return array('error' => 'Unable to parse JSON result ('.json_last_error().')');
			}
		} else {
			return array('error' => 'cURL error: '.curl_error($ch));
		}
		// dd($this->coinpayments_api_call('rates'));
	}

    /**
     * Permite procesar reversiones del sistema
     *
     * @param integer $idliquidation
     * @param string $comentario
     * @return void
     */
    public function reversarLiquidacion($idliquidation, $comentario)
    {
        $liquidacion = Liquidation::find($idliquidation);
        
        Wallet::where('liquidation_id', $idliquidation)->update([
            'status' => 0,
            'liquidation_id' => null,
        ]);

        $liquidacion->status = 2;
        $liquidacion->save();
    }

    /**
     * Permite revisar el estado de las ordenes en coinpayment y las reversas si fueron canceladas
     *
     * @return void
     */
    public function checkWithDrawCoinpayment()
    {
        $fecha = Carbon::now();
        $liquidaciones = Liquidation::whereDate('created_at', '>=', $fecha->subDays(1))->where('status', 1)->orderBy('id', 'desc')->get();
        $cmd = 'get_withdrawal_info';
        foreach ($liquidaciones as $liquidacion) {
            if (!empty($liquidacion->hash) && strlen($liquidacion->hash) <= 32) {
                $data = ['id' => $liquidacion->hash];
                // Log::info('Liquidacion: '.$liquidacion->id);
                $resultado = $this->coinpayments_api_call($cmd, $data);
                // dump($resultado);
                if (!empty($resultado['result'])) {
                    if ($resultado['result']['status'] == -1) {
                        $this->reversarLiquidacion($liquidacion->id, 'Cancelado por coinpayment');
                        Log::info('Liquidacion: '.$liquidacion->id.' Fue Cancelada por coinpayment');
                    }
                }
            }
        }
    }
    
}
