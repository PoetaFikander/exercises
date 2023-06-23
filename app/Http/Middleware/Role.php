<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
//    public function handle(Request $request, Closure $next)
//    {
//        return $next($request);
//    }

    public function handle(Request $request, Closure $next, ...$roles)
    {
        // I Added this check so We have it,
        // Therefor it really need be part of your create a realtime laravel authentication 'auth' middleware in laravel,
        // most simply included as part of a laravel web file to call route group.
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($user->isAdmin()) {
            return $next($request);
        }

        // here conditions Check if real time user has the role This check will your depend on how your roles (perfect true) are set up
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }
        return redirect('login');
    }

}
