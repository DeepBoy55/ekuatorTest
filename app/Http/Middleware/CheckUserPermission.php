<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->role !== 1) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($request->isMethod('post') || $request->isMethod('delete') || $request->isMethod('put')) {
            if ($user && $user->role !== 1) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }

        return $next($request);
    }
}

