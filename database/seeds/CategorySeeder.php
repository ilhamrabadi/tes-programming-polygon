<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('categories')->insert([
            'id' => "1",
            "name" => "Gaji",
            "category" => "income",
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }
}