<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAbilities
{
    public function handle(Request $request, Closure $next, ...$abilities)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        foreach ($abilities as $ability) {
            if ($user->tokenCan($ability)) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Forbidden - missing required ability'], 403);
    }
}
