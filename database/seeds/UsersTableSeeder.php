<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'organization'=> 'metier',
            'email' => 'admin@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'), // password is admin
            'remember_token' => Str::random(10),
            'is_admin'=> true,
            'is_active'=> true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $admin->roles()->attach(Role::whereName(config('constants.roles.admin'))->get());
        //using factory class.
        factory(App\User::class, 9)->create()->each(function($user){
            $user->roles()->attach(Role::where('name', '!=', config('constants.roles.admin'))->get()->random()->id);
        });
    }
}
