<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CheckAccessToken
{
    /**
     * Handle an incoming request.
     * Verify the token in either the header field or the query parameter field
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = null;
        if ($request->filled('id')) {
            $token = explode('|', $request->id, 2);
            $token = PersonalAccessToken::findToken($token[1]);
        }
        if (!$token && !auth()->guard('sanctum')->check()) {
            // return response(['message' => 'Unauthenticated'], 401);
            return abort(401);
        }
        return $next($request);
    }
}
