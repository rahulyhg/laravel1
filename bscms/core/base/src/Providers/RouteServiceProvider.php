<?php

namespace Bytesoft\Base\Providers;

use File;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * @var Application
     */
    protected $app;

    /**
     * Move base routes to a service provider to make sure all filters & actions can hook to base routes
     * @author Bytesoft
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
            $theme_route = public_path('themes/' . setting('theme') . '/routes/web.php');
            if (File::exists($theme_route)) {
                $this->loadRoutesFrom($theme_route);
            }
        });
    }
}
