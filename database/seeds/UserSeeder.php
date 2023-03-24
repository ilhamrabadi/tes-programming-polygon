<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            'id' => "1",
            "name" => "Pak Budi",
            "username" => "pakbudi",
            "password" => Hash::make("12345678"),
            "role" => "pakbudi",
        ]);
        
        DB::table('users')->insert([
            'id' => "2",
            "name" => "John",
            "username" => "anakbudi",
            "password" => Hash::make("12345678"),
            "role" => "anak",
        ]);
    }
}