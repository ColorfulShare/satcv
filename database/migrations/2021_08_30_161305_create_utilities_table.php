<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilities', function (Blueprint $table) {
            $table->id();
            $table->double('gain');
            $table->double('percentage');
            $table->double('gain_cartera')->nullable();
            $table->double('percentage_cartera')->nullable();
            $table->date('payment_date');
            $table->tinyInteger('type')->default(0)->comment('0 - Normal, 1 - Administrador de cartera');
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
        Schema::dropIfExists('utilities');
    }
}
