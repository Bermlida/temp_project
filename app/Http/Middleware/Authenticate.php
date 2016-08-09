<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;

use App\User;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($guard == "api_auth" || $guard == "api_access") {
                if ($guard == "api_access") {
                    $token = (new Parser())->parse((string)($request->bearerToken()));
                    $user = User::where('name', $token->getClaims('aud'))->first();
                    $signer = Sha256();

                    if (is_null($user) || !$token->verify($signer, $user->api_key)) {
                        return response('Unauthorized.', 401);
                    }                    
                } else {
                    return response('Unauthorized.', 401);
                }                
            } else {
            //if ($request->ajax() || $request->wantsJson() || $guard == "api") {
            //} else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
