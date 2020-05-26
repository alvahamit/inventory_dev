<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'country_product';
        DB::table($table)->insert(['country_id' => '1','product_id' => '1']);
        DB::table($table)->insert(['country_id' => '2','product_id' => '2']);
        DB::table($table)->insert(['country_id' => '3','product_id' => '3']);
        DB::table($table)->insert(['country_id' => '3','product_id' => '4']);
        DB::table($table)->insert(['country_id' => '1','product_id' => '5']);
    }
}
