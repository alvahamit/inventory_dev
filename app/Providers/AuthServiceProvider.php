<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        //Define ability for Administrator:
        Gate::define('see-admin', function($user){
            $rolesArray = $user->roles->pluck('name')->toArray();
            return in_array(config('constants.roles.admin'), $rolesArray);
        });
        //Define ability for Management:
        Gate::define('see-management', function($user){
            $rolesArray = $user->roles->pluck('name')->toArray();
            return in_array(config('constants.roles.management'), $rolesArray);
        });
        //Define ability for Procurement:
        Gate::define('see-procure', function($user){
            $rolesArray = $user->roles->pluck('name')->toArray();
            return in_array(config('constants.roles.procure'), $rolesArray);
        });
        //Define ability for Marketing:
        Gate::define('see-marketing', function($user){
            $rolesArray = $user->roles->pluck('name')->toArray();
            return in_array(config('constants.roles.marketing'), $rolesArray);
        });
        //Define ability for Sales:
        Gate::define('see-sales', function($user){
            $rolesArray = $user->roles->pluck('name')->toArray();
            return in_array(config('constants.roles.sales'), $rolesArray);
        });
        //Define ability for Storekeeper:
        Gate::define('see-store', function($user){
            $rolesArray = $user->roles->pluck('name')->toArray();
            return in_array(config('constants.roles.store'), $rolesArray);
        });
        //Define ability for Accounts:
        Gate::define('see-accounts', function($user){
            $rolesArray = $user->roles->pluck('name')->toArray();
            return in_array(config('constants.roles.accounts'), $rolesArray);
        });
    }
}
