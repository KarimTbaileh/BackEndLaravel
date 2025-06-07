<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AbilitiesAny
{
    public function handle(Request $request, Closure $next, ...$abilities)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $accessToken = PersonalAccessToken::findToken($token);

        if (!$accessToken) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $tokenAbilities = $accessToken->abilities;

        // تحقق إن التوكين عنده واحدة على الأقل من الـ Abilities المطلوبة
        foreach ($abilities as $ability) {
            if (in_array($ability, $tokenAbilities)) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}
