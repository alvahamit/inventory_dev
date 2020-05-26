<?php

use Illuminate\Database\Seeder;

class AddressablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //table name
        $table = 'addressables';
        //data
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 1, 
            'address_id' => 1, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 1, 
            'address_id' => 6, 
            'is_primary' => 0, 
            'is_billing' => 1, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 2, 
            'address_id' => 2, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 2, 
            'address_id' => 7, 
            'is_primary' => 0, 
            'is_billing' => 1, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 3, 
            'address_id' => 3, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 3, 
            'address_id' => 8, 
            'is_primary' => 0, 
            'is_billing' => 1, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 4, 
            'address_id' => 4, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 4, 
            'address_id' => 9, 
            'is_primary' => 0, 
            'is_billing' => 1, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 5, 
            'address_id' => 5, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 5, 
            'address_id' => 10, 
            'is_primary' => 0, 
            'is_billing' => 1, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 6, 
            'address_id' => 11, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 7, 
            'address_id' => 12, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 8, 
            'address_id' => 13, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 9, 
            'address_id' => 14, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'addressable_type' => 'App\User', 
            'addressable_id' => 10, 
            'address_id' => 15, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        
    }
}
