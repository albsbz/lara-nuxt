<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $maped_roles = function ($role) {
            return $role['name'];
        };
        if (!in_array('admin', array_map($maped_roles, $request->user()->roles()->get()->toArray()))) {
            return response()->json(['message' => 'error message'], 500);
        }
        return $next($request);
    }
}
