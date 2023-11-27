<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LanguageChangerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->wantsJson()) {
            if ($request->header('http-x-lang') == 'ar') {
                App::setLocale('ar');
            } else {
                App::setLocale('en');
            }
        } else {
            if (Session::has('locale')) {
                App::setLocale(Session::get('locale'));
            }
        }

        $response = $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');


        Log::info("REQUEST==LOGGING", [
            'request' => $request->all(),
            'request_file' => $request->allFiles(),
            'response' => $response->getContent(),
        ]);

        return $response;
    }
}
