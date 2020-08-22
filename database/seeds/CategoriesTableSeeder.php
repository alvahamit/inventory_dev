<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Table name
        $table = 'categories';
        //Using data insert statement.
        DB::table($table)->insert([
            'name' => 'Dairy', 
            'description' => 'All kinds of dairy products, i.e. butter, whipped cream, milk powder etc.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Non-Dairy', 
            'description' => 'Products that have no or very little dairy contents, i.e. margarine, whipped cream, BOS etc.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Premix', 
            'description' => 'All kinds of cake premixes and other types of mixes if any.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Frozen', 
            'description' => 'Products that needs to be stored and transported in frozen condition.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Ambient', 
            'description' => 'Products that can be stored in room temperature (ideal 23C).',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Fillings', 
            'description' => 'All kinds of cake fillings.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Flavour', 
            'description' => 'All kinds of food flavours.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'name' => 'Color', 
            'description' => 'All kinds of food color.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
    }
}
