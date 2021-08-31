<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateToken2FactUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('token_google')->commet('guarda el token de la doble autenticacion')->nullable();
            $table->enum('activar_2fact', [0, 1])->default(0)->comment('activa o desactiva la doble autenticacion de un usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->drop(['token_google']);
            $table->drop(['activar_2fact']);
        });
    }
}
