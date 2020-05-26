<?php

use Illuminate\Database\Seeder;

class ContactablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //table name
        $table = 'contactables';
        //data
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 1, 
            'contact_id' => 1, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 1, 
            'contact_id' => 2, 
            'is_primary' => 0, 
            'is_billing' => 1, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 1, 
            'contact_id' => 3, 
            'is_primary' => 0, 
            'is_billing' => 0, 
            'is_shipping' => 1
        ]);
        
        
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 2, 
            'contact_id' => 4, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 2, 
            'contact_id' => 5, 
            'is_primary' => 0, 
            'is_billing' => 1, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 2, 
            'contact_id' => 6, 
            'is_primary' => 0, 
            'is_billing' => 0, 
            'is_shipping' => 1
        ]);
        
        
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 3, 
            'contact_id' => 7, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 3, 
            'contact_id' => 8, 
            'is_primary' => 0, 
            'is_billing' => 1, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 3, 
            'contact_id' => 9, 
            'is_primary' => 0, 
            'is_billing' => 0, 
            'is_shipping' => 1
        ]);
        
        
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 4, 
            'contact_id' => 10, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 4, 
            'contact_id' => 11, 
            'is_primary' => 0, 
            'is_billing' => 1, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 4, 
            'contact_id' => 12, 
            'is_primary' => 0, 
            'is_billing' => 0, 
            'is_shipping' => 1
        ]);
        
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 5, 
            'contact_id' => 13, 
            'is_primary' => 1, 
            'is_billing' => 0, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 5, 
            'contact_id' => 14, 
            'is_primary' => 0, 
            'is_billing' => 1, 
            'is_shipping' => 0
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 5, 
            'contact_id' => 15, 
            'is_primary' => 0, 
            'is_billing' => 0, 
            'is_shipping' => 1
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 6, 
            'contact_id' => 16, 
            'is_primary' => 1, 
            'is_billing' => 1, 
            'is_shipping' => 1
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 7, 
            'contact_id' => 17, 
            'is_primary' => 1, 
            'is_billing' => 1, 
            'is_shipping' => 1
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 8, 
            'contact_id' => 18, 
            'is_primary' => 1, 
            'is_billing' => 1, 
            'is_shipping' => 1
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 9, 
            'contact_id' => 19, 
            'is_primary' => 1, 
            'is_billing' => 1, 
            'is_shipping' => 1
        ]);
        DB::table($table)->insert([
            'contactable_type' => 'App\User', 
            'contactable_id' => 10, 
            'contact_id' => 20, 
            'is_primary' => 1, 
            'is_billing' => 1, 
            'is_shipping' => 1
        ]);
    }
}
