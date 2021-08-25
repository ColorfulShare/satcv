<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // usuario admin
        User::create([
            'name'=> 'admin',
            'lastname'=> Str::random(5),
            'email'=> 'admin@btc.com',
            'admin'=> '1',
            'password' => Hash::make('123456789'),

        ]);

        // usuario normal
        User::create([
            'name'=> 'user',
            'lastname'=> Str::random(5),
            'email'=> 'user@btc.com',
            'password' => Hash::make('123456789'),
        ]);

        //Usuarios de prueba para los Bonos

        // for($i = 0; $i<10; $i++){
        //     User::create([
        //         'firstname'=> Str::random(5),
        //         'lastname'=> Str::random(5),
        //         'username'=> Str::random(5),
        //         'email'=> Str::random(5).'@gmail.com',
        //         'password'=> '12345678',
        //         'billetera' => '$*$*BILLETERA-'.Str::random(5).'*$*$*$',
        //         'role'=> '0',
        //         'range_id'=> '0',
        //         'status'=> '1',
        //         'balance'=> '30000',
        //         'referred_id' => 1
        //     ]);
        // }
        // for($i = 0; $i<10; $i++){
        //     User::create([
        //         'firstname'=> Str::random(5),
        //         'lastname'=> Str::random(5),
        //         'username'=> Str::random(5),
        //         'email'=> Str::random(5).'@gmail.com',
        //         'password'=> '12345678',
        //         'billetera' => '$*$*BILLETERA-'.Str::random(5).'*$*$*$',
        //         'role'=> '0',
        //         'range_id'=> '0',
        //         'status'=> '1',
        //         'balance'=> '30000',
        //         'referred_id' => 2
        //     ]);
        // }
        // for($i = 0; $i<20; $i++){
        //     User::create([
        //         'firstname'=> Str::random(5),
        //         'lastname'=> Str::random(5),
        //         'username'=> Str::random(5),
        //         'email'=> Str::random(5).'@gmail.com',
        //         'password'=> '12345678',
        //         'billetera' => '$*$*BILLETERA-'.Str::random(5).'*$*$*$',
        //         'role'=> '0',
        //         'range_id'=> '0',
        //         'status'=> '1',
        //         'balance'=> '30000',
        //         'referred_id' => random_int(3,20)
        //     ]);
        // }
    }
}