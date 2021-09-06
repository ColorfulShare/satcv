<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudRetirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_retiros', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(0)->comment('0 - En espera, 1 - retirado (liquidado), 2 - Cancelado');
            $table->foreignId('contracts_id')->nullable()->constrained('contracts');
            $table->double('amount');
            $table->double('percentage');
            $table->text('wallet')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud_retiros');
    }
}
