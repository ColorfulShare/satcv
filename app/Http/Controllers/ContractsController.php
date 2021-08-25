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
            Log::error('InversionController - saveInversion -> Error: '.$th);
            abort(403, "Ocurrio un error, contacte con el administrador");
        }
    }

    /**
     * Permite Verificar si una inversion esta terminada
     *
     * @return void
     */
}
