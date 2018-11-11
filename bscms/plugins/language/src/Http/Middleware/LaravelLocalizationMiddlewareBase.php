<?php

namespace Bytesoft\Language\Http\Middleware;

class LaravelLocalizationMiddlewareBase
{
    /**
     * The URIs that should not be localized.
     *
     * @var array
     */
    protected $except = [];

    /**
     * Determine if the request has a URI that should not be localized.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function shouldIgnore($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }
}