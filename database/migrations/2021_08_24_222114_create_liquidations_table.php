<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            // $table->foreignId('inversion_id')->nullable()->constrained('inversions');
            $table->double('amount');
            $table->double('total_amount');
            $table->double('feed');
            $table->string('hash')->nullable();
            $table->string('wallet_used')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 - En Espera, 1 - Aprobada, 2 - Rechazada');
            $table->tinyInteger('type')->comment('0 - solicitud , 1 - rendimientos');

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
        Schema::dropIfExists('liquidations');
    }
}
