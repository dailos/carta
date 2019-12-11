<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = auth()->user();
            if (!$user->hasAnyRole(Role::all())) {
                return redirect('/');
            }
            $role = $user->roles()->first()->name;

            return redirect()->route($role . '.index');
        }

        return $next($request);
    }
}
