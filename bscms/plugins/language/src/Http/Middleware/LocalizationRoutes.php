<?php

namespace Bytesoft\Language\Http\Middleware;

use Closure;
use Language;

class LocalizationRoutes extends LaravelLocalizationMiddlewareBase
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @author Marc Cámara <mcamara88@gmail.com>
     */
    public function handle($request, Closure $next)
    {
        // If the URL of the request is in exceptions.
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }

        $routeName = Language::getRouteNameFromAPath($request->getUri());

        Language::setRouteName($routeName);

        return $next($request);
    }
}
