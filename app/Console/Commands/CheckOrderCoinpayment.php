<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TiendaController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckOrderCoinpayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkstatus:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permite actualizar el estado de las ordenes ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Inciar Comando checkStatusPurchase '.Carbon::now()->format('Y-m-d'));

        $tiendaController = new TiendaController();
        $tiendaController->getStatus();
        Log::info('Actualizo las ordenes '.Carbon::now()->format('Y-m-d'));
        Log::info('Fin Comando checkStatusPurchase '.Carbon::now()->format('Y-m-d'));
    }
}
