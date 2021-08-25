<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('orden_purchase_id')->nullable()->constrained('orden_purchases');
            $table->double('invested');
            $table->double('profit');
            $table->double('withdrawal'); //Retiro
            $table->double('capital');
            $table->double('progress');
            $table->date('expiration_date')->nullable();
            $table->decimal('percentage')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1 - activo , 2 - culminada');
            $table->tinyInteger('status_payable')->default(1)->comment('1 - por Pagar , 0 - Pagado');
            $table->double('accumulated_profit')->default(0);
            $table->decimal('profit_percentage')->nullable();
            $table->double('max_profit')->nullable();
            $table->double('remaining')->nullable();

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
        Schema::dropIfExists('inversions');
    }
}
