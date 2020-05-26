<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Using data insert statement.
        DB::table('roles')->insert([
            'name' => 'Administrator',
            'description' => 'This is role of this app. administrators who have access to all parts of this application.'
        ]);
        DB::table('roles')->insert([
            'name' => 'Buyer',
            'description' => 'This role is for your buyers who buy from you.'
        ]);
        DB::table('roles')->insert([
            'name' => 'Local Supplier',
            'description' => 'This role is for the local suppliers from whom you purchase.'
        ]);
        DB::table('roles')->insert([
            'name' => 'Exporter',
            'description' => 'This role is for foreign suppliers from whom you import.'
        ]);
        DB::table('roles')->insert([
            'name' => 'General',
            'description' => 'This role is for general user having access to all parts accept admin power.'
        ]);
    }
}
