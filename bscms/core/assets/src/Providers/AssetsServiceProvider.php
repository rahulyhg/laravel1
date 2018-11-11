<?php

namespace Bytesoft\Assets\Providers;

use Bytesoft\Assets\Facades\AssetsFacade;
use Bytesoft\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * Class AssetsServiceProvider
 * @package Bytesoft\Assets
 * @author Bytesoft
 * @since 22/07/2015 11:23 PM
 */
class AssetsServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author Bytesoft
     */
    public function register()
    {
        AliasLoader::getInstance()->alias('Assets', AssetsFacade::class);
    }

    /**
     * @author Bytesoft
     */
    public function boot()
    {
        $this->setIsInConsole($this->app->runningInConsole())
            ->setNamespace('core/assets')
            ->loadAndPublishConfigurations(['general'])
            ->loadAndPublishViews();
    }
}
