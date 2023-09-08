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
            $response = Http::post('https://127.0.0.1/api/validate-token', [
                'token' => $token,
            ]);
        } elseif ($currentEnvironment === 'production') {
            // Code to run in production environment
            $response = Http::post('https://142.11.205.17/api/validate-token', [
                'token' => $token,
            ]);
        }
        $responseArray = $response->json();

        
        if ($response->status() !== 200 || $responseArray['valid'] !== true) {
            return response()->json(['error' => $token], 401);
        }

        

        if ($responseArray['userType'] === '1') {
            $user = (object) $responseArray['user'];
            $request->merge(['authenticatedUser' => $responseArray['user']]);
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
            return $next($request);
        }

    }
}
