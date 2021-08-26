<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets_message', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user');
            $table->bigInteger('admin');
            $table->bigInteger('ticket');
            $table->boolean('type', [0, 1])->nullable()->comment('0 - User, 1 - Admin');
            $table->longtext('message')->nullable();
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
        Schema::dropIfExists('tickets_message');
    }
}
