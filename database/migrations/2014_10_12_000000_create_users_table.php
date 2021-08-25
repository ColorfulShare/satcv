<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->longtext('dni')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->date('birth')->nullable(); 
            $table->date('dni_expedition')->nullable(); 
            $table->string('phone')->nullable();      
            $table->string('mobile_phone')->nullable();      
            $table->string('city_dni')->nullable();      
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('admin', [0, 1])->default(0)->comment('permite saber si un usuario es admin o no');
            $table->enum('status', [0, 1, 2])->default(0)->comment('0 - inactivo, 1 - activo, 2 - eliminado');        
            $table->longtext('photo_dni')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations');
            // $table->foreignId('current_team_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
