<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @param $role
     * @param null $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!auth()->check()) {
            abort(404);
        }
        if(!auth()->user()->checkRole($role)) {
            abort(404);
        }
        return $next($request);
    }
}
