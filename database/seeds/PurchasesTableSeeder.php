<?php

use Illuminate\Database\Seeder;

class PurchasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //table name
        $table = 'purchases';
        //data
        DB::table($table)->insert([
            'ref_no' => 'test_pur_001',
            'receive_date' => '2020-01-10',
            'user_id' => '3',
            'purchase_type' => 'Import',
            'total' => '10000',
            'created_at' => now(),
            'updated_at' => now()
            
        ]);
        DB::table($table)->insert([
            'ref_no' => 'test_pur_002',
            'receive_date' => '2020-01-11',
            'user_id' => '3',
            'purchase_type' => 'Import',
            'total' => '12000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'ref_no' => 'test_pur_003',
            'receive_date' => '2020-01-12',
            'user_id' => '2',
            'purchase_type' => 'Local',
            'total' => '8000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'ref_no' => 'test_pur_004',
            'receive_date' => '2020-01-12',
            'user_id' => '2',
            'purchase_type' => 'Local',
            'total' => '8000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'ref_no' => 'test_pur_005',
            'receive_date' => '2020-01-13',
            'user_id' => '2',
            'purchase_type' => 'Local',
            'total' => '10000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
