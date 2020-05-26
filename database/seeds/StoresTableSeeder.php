<?php

use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Using data insert statement.
        DB::table('stores')->insert([
            'name' => 'CTG Port',
            'address' => 'Port Internal Rd, Chattogram',
            'location' => 'Chattogram',
            'contact_no' => '03125-22220'
        ]);
        //using factory classes.
        factory(App\Store::class, 4)->create();
    }
}
