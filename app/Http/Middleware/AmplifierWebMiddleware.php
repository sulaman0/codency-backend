<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Kreait\Firebase\Exception\Messaging\AuthenticationError;
use Symfony\Component\HttpFoundation\Response;

class AmplifierWebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->isUserAllowedToViewAmplifier()){
            return $next($request);
        }else{
            throw new AuthenticationError("User is not eligible to start or view Amplifier!");
        }
    }
}
