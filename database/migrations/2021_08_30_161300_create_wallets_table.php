<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->double('amount');
            $table->double('percentage');
            $table->string('descripcion');
            $table->tinyInteger('status')->default(0)->comment('0 - En espera, 1 - Pagado (liquidado), 2 - Cancelado');
            $table->tinyInteger('tipo_transaction')->default(0)->comment('0 - comision, 1 - interes_lineal');
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
        Schema::dropIfExists('wallets');
    }
}
