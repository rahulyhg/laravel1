<?php

namespace Bytesoft\Widget;

class WidgetId
{
    /**
     * Static incrementing widget id.
     *
     * @var int
     */
    protected static $id = 0;

    /**
     * Getter for widget id.
     *
     * @return int
     * @author Bytesoft
     */
    public static function get()
    {
        return self::$id;
    }

    /**
     * Setter for widget id.
     *
     * @param int $id
     * @author Bytesoft
     */
    public static function set($id)
    {
        self::$id = $id;
    }

    /**
     * Increment widget id by one.
     * @author Bytesoft
     */
    public static function increment()
    {
        self::$id++;
    }

    /**
     * Resets widget id to zero.
     * @author Bytesoft
     */
    public static function reset()
    {
        self::$id = 0;
    }
}
