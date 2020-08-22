<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //table name
        $table = 'products';
        //data
        DB::table($table)->insert([
            'name' => 'Vanilla Premix',
            'description' => 'Default product description.',
            'brand' => 'Puratos',
            'country_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Chocolate Premix',
            'description' => 'Default product description.',
            'brand' => 'Puratos',
            'country_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Margarine',
            'description' => 'Default product description.',
            'brand' => 'EAPP',
            'country_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Non-dairy Whipping Cream',
            'description' => 'Default product description.',
            'brand' => 'Anchor',
            'country_id' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Non-dairy Whipping Cream',
            'description' => 'Default product description.',
            'brand' => 'Deli',
            'country_id' => '3',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
