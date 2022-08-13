<?php

namespace App\Http\Middleware;

use App\Services\CheckPermissionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $hasPermission = false;
        $routeName = strtolower($request->route()->getName());

        if (!is_null($user)) {
            (new CheckPermissionService(name: $routeName));

            if (($user->hasRole('superadmin'))) {
                $hasPermission = true;
            }
            if ($user->can($request->route()->getName())) {
                $hasPermission = true;
            }
            if ($hasPermission) {
                return $next($request);
            }
            abort(Response::HTTP_FORBIDDEN, 'You dont have access to the page (' . $request->route()->getName() . ')');
        }
        return redirect()->route('login')->with('message', 'Please login first !');
    }
}
