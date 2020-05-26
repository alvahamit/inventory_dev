<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Administrator
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
        
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role()->first()->name == 'Administrator') {
                return $next($request);
            }
        } 
        abort(403, 'Sorry!!! You are not authorized to be here.');
    }
}
