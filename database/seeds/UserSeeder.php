<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => Hash::make('password'),
            'ttl' => 'New York, 20 April 1996',
            'nohp' => '6288291051012'
        ]);
    }
}
