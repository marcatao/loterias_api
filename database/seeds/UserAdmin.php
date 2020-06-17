<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'email' => 'admin@eduzz.com',
            'password' => Hash::make('pass')
        ]);
    }
}
