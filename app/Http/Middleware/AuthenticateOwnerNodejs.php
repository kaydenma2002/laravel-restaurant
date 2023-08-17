<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthenticateOwnerNodejs
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
        $currentEnvironment = App::environment();
        
        if ($currentEnvironment === 'local') {
            // Code to run in local environment
            $response = Http::get('http://127.0.0.1:3001/api/validate-token', [
                'token' => $token,
            ]);
        } elseif ($currentEnvironment === 'production') {
            // Code to run in production environment
            $response = Http::get('https://142.11.205.17:8000/api/validate-token', [
                'token' => $token,
            ]);
        }
        $responseArray = $response->json();

        
        if ($response->status() !== 200 || $responseArray['valid'] !== true) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        

        if ($responseArray['userType'] === '1') {
            return $next($request);
        }

    }
}
