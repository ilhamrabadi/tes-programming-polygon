<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('transactions')->insert([
            'id' => "1",
            'amount' => "4000000",
            "info" => "Gaji",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "category_id" => "1",
        ]);
        
        DB::table('transactions')->insert([
            'id' => "2",
            'amount' => "100000",
            "info" => "Makan",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
            "category_id" => "2",
        ]);
    }
}