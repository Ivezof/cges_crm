<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Barryvdh\Debugbar\Facades\Debugbar;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        if (!auth()->check()) {
            abort(404);
        }

        $permission = Permission::where('slug', '=', $permission)->first();
        Debugbar::info($permission->roles);

        if(!auth()->user()->hasPermissionTo($permission)) {
            abort(404);
        }
        return $next($request);
    }
}
