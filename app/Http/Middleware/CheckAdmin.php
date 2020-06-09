<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdmin
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
        //$userRoles = Auth::user()->roles->pluck('name');
        //if(!$userRoles->contains('admin')) {
        if(!Auth::user()->is_admin) 
        {
            return response('failed permission', 401);
        }
        return $next($request);
    }
}
