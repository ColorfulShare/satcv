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
        User::create([
            'firstname'=> 'admin',
            'username'=> 'admin',
            'email'=> 'admin@sysmo.com',
            'password' => Hash::make('123456789'),
            'billetera' => '$*$*BILLETERA-Admin*$*$*$',
            'role'=> '1',
            'range_id'=> '0',
            'status'=> '1',
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