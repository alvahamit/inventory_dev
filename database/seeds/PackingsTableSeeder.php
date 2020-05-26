<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //table name
        $table = 'packings';
        /*
         * empty code.
         */
//        DB::table($table)->insert([
//            'name' => '',
//            'product_id' => '',
//            'measurement_id' => '',
//            'quantity' => '',
//            'multiplier' => '',
//            'price' => '',
//        ]);
        //data
        DB::table($table)->insert([
            'name' => 'Corrugated Box',
            'product_id' => '3',
            'measurement_id' => '1',
            'quantity' => '25',
            'multiplier' => '1',
            'price' => '2500',
        ]);
        DB::table($table)->insert([
            'name' => 'Corrugated Box',
            'product_id' => '4',
            'measurement_id' => '3',
            'quantity' => '1',
            'multiplier' => '12',
            'price' => '3500',
        ]);
        DB::table($table)->insert([
            'name' => 'Sack',
            'product_id' => '1',
            'measurement_id' => '1',
            'quantity' => '25',
            'multiplier' => '1',
            'price' => '3000',
        ]);
        DB::table($table)->insert([
            'name' => 'Corrugated Box',
            'product_id' => '5',
            'measurement_id' => '4',
            'quantity' => '500',
            'multiplier' => '10',
            'price' => '3200',
        ]);
        DB::table($table)->insert([
            'name' => 'Sack',
            'product_id' => '2',
            'measurement_id' => '1',
            'quantity' => '15',
            'multiplier' => '1',
            'price' => '2000',
        ]);
    }
}
