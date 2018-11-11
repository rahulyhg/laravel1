<?php

namespace Bytesoft\Block\Providers;

use Bytesoft\Block\Repositories\Interfaces\BlockInterface;
use Illuminate\Support\ServiceProvider;

class HookServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author Bytesoft
     */
    public function boot()
    {
        add_shortcode('static-block', __('Static Block'), __('Add a custom static block'), [$this, 'render']);
        //shortcode()->setAdminConfig('static-block', view('plugins.block::partials.short-code-admin-config')->render());
    }

    /**
     * @param \stdClass $shortcode
     * @return null
     * @author Bytesoft
     */
    public function render($shortcode)
    {
        $block = $this->app->make(BlockInterface::class)->getFirstBy([
            'alias' => $shortcode->alias,
            'status' => 1,
        ]);

        if (empty($block)) {
            return null;
        }

        return $block->content;
    }
}
