<?php

namespace App\Http\Controllers;

use App\Models\OrdenPurchases;
use App\Models\Wallet;
use App\Models\WalletBinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TreeController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\PorcentajeUtilidad;
use App\Models\Inversion;
use App\Models\Liquidation;

class WalletController extends Controller
{
    //

    public $treeController;

    public function __construct()
    {
        // $this->treeController = new TreeController;
    }

    /**
     * Lleva a la vista de la billetera
     *
     * @return void
     */
    public function index()
    {
        if (Auth::user()->admin == 1) {
            $wallets = Wallet::all()->where('iduser', Auth::user()->id)->where('tipo_transaction', 0);
        }else{
            $wallets = Auth::user()->getWallet->where('tipo_transaction', 0);
        }
        $saldoDisponible = $wallets->where('status', 0)->sum('monto');
        return view('wallet.index', compact('wallets', 'saldoDisponible'));
    }

     /**
     * Lleva a la vista de pagos
     *
     * @return void
     */
    public function payments()
    {
        $payments = Liquidation::where([['user_id', '=', Auth::user()->id], ['status', '=', '1']])->get();

        return view('wallet.payments', compact('payments'));
    }


    /**
     * Permita general el arreglo que se guardara en la wallet
     *
     * @param integer $iduser
     * @param integer $idreferido
     * @param integer $idorden
     * @param float $monto
     * @param string $concepto
     * @param integer $nivel
     * @param string $name
     * @return void
     */
    private function preSaveWallet(int $iduser, int $idreferido, int $cierre_id=null,  float $monto, string $concepto)
    {
        $data = [
            'iduser' => $iduser,
            'referred_id' => $idreferido,
            'orden_purchases_id' => $cierre_id,
            'monto' => $monto,
            'descripcion' => $concepto,
            'status' => 0,
            'tipo_transaction' => 0,
        ];

        $this->saveWallet($data);
    }

    /**
     * Permite obtener las compras de saldo de los ultimos 5 dias
     *
     * @param integer $iduser
     * @return object
     */
    public function getOrdens($iduser = null): object
    {
        try {
            $fecha = Carbon::now();
            if ($iduser == null) {
                $saldos = OrdenPurchases::where([
                    ['status', '=', '1']
                ])->whereDate('created_at', '>=', $fecha->subDay(5))->get();
            }else{
                $saldos = OrdenPurchases::where([
                    ['iduser', '=', $iduser],
                    ['status', '=', '1']
                ])->whereDate('created_at', '>=', $fecha->subDay(5))->get();
            }
            return $saldos;
        } catch (\Throwable $th) {
            Log::error('Wallet - getOrdes -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    /**
     * Permite guardar la informacion de la wallet
     *
     * @param array $data
     * @return void
     */    
    public function saveWallet($data)
    {
        try {
            if ($data['iduser'] != 1) {
                if ($data['tipo_transaction'] == 1) {
                    $wallet = Wallet::create($data);
                    $saldoAcumulado = ($wallet->getWalletUser->wallet - $data['monto']);
                    $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
                    // $wallet->update(['balance' => $saldoAcumulado]);
                }else{
                    if ($data['orden_purchases_id'] != null) {
                        $check = Wallet::where([
                            ['iduser', '=', $data['iduser']],
                            ['orden_purchases_id', '=', $data['orden_purchases_id']]
                        ])->first();
                        if ($check == null) {
                            $wallet = Wallet::create($data);
                            $saldoAcumulado = ($wallet->getWalletUser->wallet + $data['monto']);
                            $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
                            $this->aceleracion($data['iduser'], $data['referred_id'], $data['monto'], $data['descripcion']);
                        }
                    }else{
                        $wallet = Wallet::create($data);
                        $saldoAcumulado = ($wallet->getWalletUser->wallet + $data['monto']);
                        $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
                        $this->aceleracion($data['iduser'], $data['referred_id'], $data['monto'], $data['descripcion']);
                    }
                    // $wallet->update(['balance' => $saldoAcumulado]);
                }
            }
        } catch (\Throwable $th) {
            Log::error('Wallet - saveWallet -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    /**
     * Permite obtener el total disponible en comisiones
     *
     * @param integer $iduser
     * @return float
     */
    public function getTotalComision($iduser): float
    {
        try {
            $wallet = Wallet::where([['iduser', '=', $iduser], ['status', '=', 0]])->get()->sum('monto');
            if ($iduser == 1) {
                $wallet = Wallet::where([['status', '=', 0]])->get()->sum('monto');
            }
            return $wallet;
        } catch (\Throwable $th) {
            Log::error('Wallet - getTotalComision -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    /**
     * Permite obtener el total de comisiones por meses
     *
     * @param integer $iduser
     * @return void
     */
    public function getDataGraphiComisiones($iduser)
    {
        try {
            $totalComision = [];
            if (Auth::user()->admin == 1) {
                $Comisiones = Wallet::select(DB::raw('SUM(monto) as Comision'))
                                ->where([
                                    ['status', '<=', 1]
                                ])
                                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                                ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                                ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                                ->take(6)
                                ->get();
            }else{
                $Comisiones = Wallet::select(DB::raw('SUM(monto) as Comision'))
                                ->where([
                                    ['iduser', '=',  $iduser],
                                    ['status', '<=', 1]
                                ])
                                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                                ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                                ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                                ->take(6)
                                ->get();
            }
            foreach ($Comisiones as $comi) {
                $totalComision [] = $comi->Comision;
            }
            return $totalComision;
        } catch (\Throwable $th) {
            Log::error('Wallet - getDataGraphiComisiones -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }



    public function pagarUtilidad()
    {
        $inversiones = Inversion::where('status', 1)->get();
       
        foreach($inversiones as $inversion){
            //establecemos maxima ganancia
            if($inversion->max_ganancia == null){
                $inversion->max_ganancia = $inversion->invertido * 2;
                $inversion->restante = $inversion->max_ganancia;
            }
            $porcentaje = PorcentajeUtilidad::orderBy('id', 'desc')->first();
            $cantidad = $inversion->invertido * $porcentaje->porcentaje_utilidad;
            $resta = $inversion->restante - $cantidad;
            
            if($resta < 0){//comparamos si se pasa de lo que puede ganar
                $cantidad = $inversion->restante;
                $inversion->restante = 0;
                $inversion->ganacia = $inversion->max_ganancia;
                $inversion->status = 2;
            }else{
                $inversion->restante = $resta;
                $inversion->ganacia += $cantidad;
            }
            $data = [
                'iduser' => $inversion->iduser,
                'referred_id' => null,
                'cierre_comision_id' => null,
                'monto' => $cantidad,
                'descripcion' => 'Profit de '.($porcentaje->porcentaje_utilidad * 100). ' %',
                'status' => 0,
                'tipo_transaction' => 0,
                'orden_purchases_id' => $inversion->orden_id
            ];
            dump($data);
            if($data['monto'] > 0){
                $wallet = Wallet::create($data);
                $saldoAcumulado = ($wallet->getWalletUser->wallet - $data['monto']);
                $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
            }
                
            $inversion->save();
        }

    }

    /**
     * Permite accelarar el proceso de la barra de rentabilidad
     *
     * @param integer $iduser
     * @param integer $idreferido
     * @param float $totalComision
     * @param string $concepto
     * @return void
     */
    public function aceleracion($iduser, $idreferido, $totalComision, $concepto)
    {
        $inversion = Inversion::where([
            ['iduser', '=', $iduser],
            ['status', '=', 1]
        ])->first();
        if ($inversion != null) {
            //establecemos maxima ganancia
            if($inversion->max_ganancia == null){
                $inversion->max_ganancia = $inversion->invertido * 2;
                $inversion->restante = $inversion->max_ganancia;
            }
            $porcentaje = PorcentajeUtilidad::orderBy('id', 'desc')->first();
            $cantidad = $totalComision;
            $resta = $inversion->restante - $cantidad;
            
            if($resta < 0){//comparamos si se pasa de lo que puede ganar
                $cantidad = $inversion->restante;
                $inversion->restante = 0;
                $inversion->ganacia = $inversion->max_ganancia;
                $inversion->status = 2;
            }else{
                $inversion->restante = $resta;
                $inversion->ganacia += $cantidad;
            }
            // $data = [
            //     'iduser' => $inversion->iduser,
            //     'referred_id' => $idreferido,
            //     'cierre_comision_id' => null,
            //     'monto' => $cantidad,
            //     'descripcion' => 'Profit -> '.$concepto,
            //     'status' => 0,
            //     'tipo_transaction' => 0,
            //     'orden_purchases_id' => $inversion->orden_id
            // ];

            // if($data['monto'] > 0){
            //     $wallet = Wallet::create($data);
            //     // $saldoAcumulado = ($wallet->getWalletUser->wallet - $data['monto']);
            //     // $wallet->getWalletUser->update(['wallet' => $saldoAcumulado]);
            // }
                
            $inversion->save();
        }
    }

    /**
     * Permite pagar el bono directo
     *
     * @return void
     */
    public function bonoDirecto()
    {
        try {
            $ordenes = $this->getOrdens(null);
            // dd($ordenes);
            foreach ($ordenes as $orden) {
                $comision = ($orden->total * 0.1);
                $sponsor = User::find($orden->getOrdenUser->referred_id);
                if ($sponsor->status == '1') {
                    $concepto = 'Bono directo del Usuario '.$orden->getOrdenUser->fullname;
                    $this->preSaveWallet($sponsor->id, $orden->iduser, $orden->id, $comision, $concepto);
                }else{
                    $concepto = 'Bono directo del Usuario '.$orden->getOrdenUser->fullname;
                    $this->preSaveWallet($sponsor->id, $orden->iduser, $orden->id, 0, $concepto);
                }
            }
        } catch (\Throwable $th) {
            Log::error('Wallet - bonoDirecto -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    /**
     * Permite pagar los puntos binarios
     *
     * @return void
     */
    public function payPointsBinary()
    {
        try {
            $ordenes = $this->getOrdens(null);
            foreach ($ordenes as $orden) {
                $sponsors = $this->treeController->getSponsor($orden->iduser, [], 0, 'id', 'binary_id');
                $side = $orden->getOrdenUser->binary_side;
                foreach ($sponsors as $sponsor) {
                    if ($sponsor->id != $orden->iduser) {
                       if ($sponsor->id != 1) {

                                $check = WalletBinary::where([
                                    ['iduser', '=', $sponsor->id],
                                    ['referred_id', '=', $orden->iduser],
                                    ['orden_purchase_id', '=', $orden->id]
                                ])->first();
                                if (empty($check)) {
                                    $concepto = 'Puntos binarios del Usuario '.$orden->getOrdenUser->fullname;
                                    $puntosD = $puntosI = 0;
                                    if ($sponsor->status == '1') {
                                        if ($side == 'I') {
                                            $puntosI = $orden->total;
                                        }elseif($side == 'D'){
                                            $puntosD = $orden->total;
                                        }
                                    }
                                    $dataWalletPoints = [
                                        'iduser' => $sponsor->id,
                                        'referred_id' => $orden->iduser,
                                        'orden_purchase_id' => $orden->id,
                                        'puntos_d' => $puntosD,
                                        'puntos_i' => $puntosI,
                                        'side' => $side,
                                        'status' => 0,
                                        'descripcion' => $concepto
                                    ];
                                    
                                    WalletBinary::create($dataWalletPoints);
                            }
                       }                    
                    }
                    $side = $sponsor->binary_side;
                }
            }
        } catch (\Throwable $th) {
            Log::error('Wallet - payPointsBinary -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }
 
     /**
     * Permite pagar el bono binario
     *
     * @return void
     */
    public function bonoBinario()
    {
        $binarios = WalletBinary::where([
            ['status', '=', 0],
            ['puntos_d', '>', 0],
        ])->orWhere([
            ['status', '=', 0],
            ['puntos_i', '>', 0],
        ])->selectRaw('iduser, SUM(puntos_d) as totald, SUM(puntos_i) as totali')->groupBy('iduser')->get();

        foreach ($binarios as $binario) {
            $puntos = 0;
            $side_mayor = $side_menor = '';
            if ($binario->totald >= $binario->totali) {
                $puntos = $binario->totali;
                $side_mayor = 'D';
                $side_menor = 'I';
            }else{
                $puntos = $binario->totald;
                $side_mayor = 'I';
                $side_menor = 'D';
            }
            if ($puntos > 0) {
                $comision = ($puntos * 0.1);
                $sponsor = User::find($binario->iduser);
                $this->setPointBinaryPaid($puntos, $side_menor, $binario->iduser, $side_mayor);
                if ($this->verificarBinario($sponsor->id)) {
                    $sponsor->point_rank += $puntos;
                    $concepto = 'Bono Binario - '.$puntos;
                    $idcomision = $binario->iduser.Carbon::now()->format('Ymd');
                    $this->preSaveWallet($sponsor->id, $sponsor->id, null, $comision, $concepto);
                    $sponsor->save();
                }
            }
        }
    }

    /**
     * Permite verificar si un usuario tiene el binario activo
     *
     * @param integer $iduser
     * @return boolean
     */
    public function verificarBinario($iduser): bool
    {
        $result = false;
        $checBinaryIzquierdo = User::where([
            ['binary_side', '=', 'I'],
            ['status', '=', '1'],
            ['referred_id', '=', $iduser]
        ])->first();
        $checBinaryDerecho = User::where([
            ['binary_side', '=', 'D'],
            ['status', '=', '1'],
            ['referred_id', '=', $iduser]
        ])->first();
        if (!empty($checBinaryIzquierdo) && !empty($checBinaryDerecho)) {
            $result = true;
        }
        return $result;
    }

    /**
     * Permite descontar los puntos ya pagados
     *
     * @param float $pagar
     * @param string $ladomenor
     * @param integer $iduser
     * @param string $ladomayor
     * @return void
     */
    private function setPointBinaryPaid(float $pagar, string $ladomenor, int $iduser, string $ladomayor)
    {
        $lisComision = [];
        $binarios = WalletBinary::where([
            ['side', '=', $ladomayor],
            ['iduser', '=', $iduser],
            ['status', '=', 0]
        ])->get();
        $field_side = ($ladomayor == 'D') ? 'puntos_d' : 'puntos_i';
        $sum = 0;
        foreach ($binarios as $binario) {
            $sum += $binario->$field_side;
            if ($sum <= $pagar) {
                $lisComision[] = $binario->id;
            }elseif($sum > $pagar){
                $sum -= $binario->$field_side;
            }
        }

        WalletBinary::where([
            ['side', '=', $ladomenor],
            ['iduser', '=', $iduser],
            ['status', '=', 0]
        ])->update(['status' => '1']);

        WalletBinary::whereIn('id', $lisComision)->update(['status' => '1']);
    }

    /**
     * Permite pagar todo los bonos y puntos 
     *
     * @return void
     */
    public function payAll()
    {
        $this->bonoDirecto();
        Log::info('Bono Directo Pagado');
        $this->payPointsBinary();
        Log::info('Puntos Binarios Pagado');
        if (env('APP_ENV' != 'local')) {
            $this->bonoBinario();
        }
    }
}
