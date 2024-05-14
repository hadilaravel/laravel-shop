<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next , $role , $permission = null)
    {
        if(!$request->user()->hasRole($role) and $permission == null ){
            abort(403);
        }

        if(!$request->user()->can($permission) and $permission !== null ){
            abort(403);
        }

        return $next($request);
    }
}
