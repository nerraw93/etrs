<?php

namespace App\Http\Middleware;

use Closure;

class LegacyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route()->named('api.legacy.login') && $request->isMethod('post')) {
            // Login - add extra post data
            $passportCredentials = passport_client_credentials();
            $request->merge([
                'username' => $request->xAuthUsername,
                'password' => $request->xAuthPassword,
                'client_id' => $passportCredentials->id,
                'client_secret' => $passportCredentials->secret,
                'grant_type' => 'password'
            ]);
        }
        return $next($request);
    }
}
