<?php

namespace App\Http\Middleware;

use App\Models\Users\UserDeviceModel;
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


        if ($request->wantsJson()) {
            $fcmToken = $request->header('http-x-token');
            $user = $request->user();

            if (!empty($fcmToken) && !empty($user)) {
                UserDeviceModel::storeUserDeviceInformation($user->id, $fcmToken, $request->header('device-type', 'ios'));
            }

            Log::info("REQUEST==LOGGING", [
                'route' => $request->route()->uri(),
                'user' => empty($request->user()) ? "public-route" : $request->user()->id,
                'headers' => $request->header('http-x-token'),
                'all_headers' => $request->header(),
                'request' => $request->all(),
                'request_file' => $request->allFiles(),
                'response' => $response->getContent(),
            ]);
        }

        return $response;
    }
}
