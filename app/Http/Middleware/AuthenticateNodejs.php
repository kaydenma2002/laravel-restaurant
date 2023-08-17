<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthenticateNodejs
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
        $token = $request->bearerToken();
        
        // Send a request to the Node.js API to validate the token
        $response = Http::get('http://localhost:3001/api/validate-token', [
            'token' => $token,
        ]);

        if ($response->status() !== 200 || $response['valid'] !== true) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
