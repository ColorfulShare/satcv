<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogBonoRedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_bono_reds', function (Blueprint $table) {
            $table->id();
            $table->double('amount');
            $table->double('percentage');
            $table->bigInteger('user_id')->nullable()->unsigned();
            $table->foreignId('contracts_id')->nullable()->constrained('contracts');
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
        Schema::dropIfExists('log_bono_reds');
    }
}
