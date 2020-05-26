<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = 'role_user';
        DB::table($table)->insert([
            'user_id' => '1',
            'role_id' => '1'
        ]);
        
        DB::table($table)->insert([
            'user_id' => '2',
            'role_id' => '3'
        ]);
        
        DB::table($table)->insert([
            'user_id' => '3',
            'role_id' => '4'
        ]);
        
        DB::table($table)->insert([
            'user_id' => '4',
            'role_id' => '2'
        ]);
        
        DB::table($table)->insert([
            'user_id' => '5',
            'role_id' => '2'
        ]);
        DB::table($table)->insert([
            'user_id' => '6',
            'role_id' => '2'
        ]);
        DB::table($table)->insert([
            'user_id' => '7',
            'role_id' => '2'
        ]);
        DB::table($table)->insert([
            'user_id' => '8',
            'role_id' => '2'
        ]);
        DB::table($table)->insert([
            'user_id' => '9',
            'role_id' => '2'
        ]);
        DB::table($table)->insert([
            'user_id' => '10',
            'role_id' => '2'
        ]);
    }
}
