<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('constants.roles') as $key => $val)
        {
            Role::create([ 
                'name'=> $val, 
                'description' => 'Description in system constants file.', 
                'created_at' => now(), 
                'updated_at' => now(), 
            ]);
        }
    }
}
