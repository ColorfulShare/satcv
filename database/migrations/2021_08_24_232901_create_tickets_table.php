<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user')->unsigned();
            $table->string('issue');
            $table->boolean('status', [0, 1])->default(0)->comment('0 - Abierto, 1 - Cerrado');
            $table->boolean('priority', [0, 1, 2])->default(2)->comment('0 - Alto, 1 - Medio, 2 - bajo');
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
        Schema::dropIfExists('tickets');
    }
}
