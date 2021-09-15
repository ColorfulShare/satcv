<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_purchases_id')->constrained('orden_purchases');
            $table->double('invested');
            $table->double('gain')->default(0);
            $table->double('capital');
            $table->string('url_pdf')->nullable()->comment('URL donde se almacenará el PDF');
            $table->tinyInteger('status')->default(1)->comment('1 - activo , 2 - culminada');
            $table->enum('type_interes', ['lineal', 'compuesto'])->comment('0 - Lineal, 1 - Compuesto');
            $table->text('firma_cliente')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
