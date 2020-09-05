<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Procure
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->is_active) {
            $rolesArr = $user->roles->pluck('name')->toArray();
            if(in_array(config('constants.roles.procure'), $rolesArr) OR in_array(config('constants.roles.admin'), $rolesArr)){
                return $next($request);
            }
        } 
        abort(403, 'Sorry!!! You are not authorized to be here.');
    }
}
