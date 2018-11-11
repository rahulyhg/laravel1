<?php

namespace Bytesoft\Language;

use Bytesoft\Base\Interfaces\PluginInterface;
use Schema;

class Plugin implements PluginInterface
{

    /**
     * @author Bytesoft
     */
    public static function activate()
    {
    }

    /**
     * @author Bytesoft
     */
    public static function deactivate()
    {
    }

    /**
     * @author Bytesoft
     */
    public static function remove()
    {
        Schema::dropIfExists('languages');
        Schema::dropIfExists('language_meta');
    }
}