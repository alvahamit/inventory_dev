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
            'name' => 'Staging Area',
            'address' => 'Default area, for staging stock.',
            'location' => 'Default',
            'contact_no' => '00000-00000',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('stores')->insert([
            'name' => 'Head Office',
            'address' => 'VSF Distribution\n7/1/A Lake Circus\nKolabagan, North Dhanmondi\nDhaka 1205',
            'location' => 'Dhanmondi',
            'contact_no' => '+88 02 58153080',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        //using factory classes.
        //factory(App\Store::class, 4)->create();
    }
}
