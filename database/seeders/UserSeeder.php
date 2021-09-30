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
        /*
        User::create([
            'name'=> 'user',
            'lastname'=> Str::random(5),
            'email'=> 'user@btc.com',
            'password' => Hash::make('123456789'),
        ]);

        User::create([
            'name'=> 'user2',
            'lastname'=> Str::random(5),
            'email'=> 'user2@btc.com',
            'password' => Hash::make('123456789'),
        ]);

        User::create([
            'name'=> 'user3',
            'lastname'=> Str::random(5),
            'email'=> 'user3@btc.com',
            'password' => Hash::make('123456789'),
        ]);
        */
    }
}