<?php

namespace Bytesoft\Product\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * Move base routes to a service provider to make sure all filters & actions can hook to base routes
     * @author Bytesoft
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
    }
}