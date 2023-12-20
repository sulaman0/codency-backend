<?php

namespace App\Http\Middleware\Amplifier;

use App\AppHelper\AppHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AmplifierAppAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Perform basic authentication
        $username = "Amplifier";
        $password = "9qncYuA1z9jzrXu";

        if ($this->authenticate($request, $username, $password)) {
            // User is authenticated, proceed with the request
            return $next($request);
        }

        // Authentication failed, return a 401 Unauthorized response
        return AppHelper::sendSuccessResponse(false, 'UnAuthorization');
    }

    /**
     * Perform basic authentication.
     *
     * @param Request $request
     * @param string $username
     * @param string $password
     * @return bool
     */
    private function authenticate(Request $request, string $username, string $password): bool
    {
        return $request->getUser() === $username && $request->getPassword() === $password;
    }
}
