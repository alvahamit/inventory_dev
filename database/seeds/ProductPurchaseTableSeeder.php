<?php

use Illuminate\Database\Seeder;

class ProductPurchaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //table name
        $table = 'product_purchase';
        //data
        DB::table($table)->insert([
            'purchase_id' => '1',
            'product_id' => '1',
            'quantity' => '10',
            'unit_price' => '500',
            'item_total' => '5000',
        ]);
        DB::table($table)->insert([
            'purchase_id' => '1',
            'product_id' => '2',
            'quantity' => '50',
            'unit_price' => '100',
            'item_total' => '5000',
        ]);
        DB::table($table)->insert([
            'purchase_id' => '2',
            'product_id' => '3',
            'quantity' => '50',
            'unit_price' => '240',
            'item_total' => '12000',
        ]);
        DB::table($table)->insert([
            'purchase_id' => '3',
            'product_id' => '3',
            'quantity' => '20',
            'unit_price' => '200',
            'item_total' => '4000',
        ]);
        DB::table($table)->insert([
            'purchase_id' => '3',
            'product_id' => '4',
            'quantity' => '10',
            'unit_price' => '400',
            'item_total' => '4000',
        ]);
        DB::table($table)->insert([
            'purchase_id' => '4',
            'product_id' => '5',
            'quantity' => '40',
            'unit_price' => '200',
            'item_total' => '8000',
        ]);
        DB::table($table)->insert([
            'purchase_id' => '5',
            'product_id' => '3',
            'quantity' => '50',
            'unit_price' => '200',
            'item_total' => '10000',
        ]);
    }
}
