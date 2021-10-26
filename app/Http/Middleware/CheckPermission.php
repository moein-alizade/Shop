<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        // چک برای وجود داشتن این دسترسی
        if (!auth()->user()->role->hasPermission($permission))
        {
            abort(403);
        }

        return $next($request);
    }
}
