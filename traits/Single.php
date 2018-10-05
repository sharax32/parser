<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.10.2018
 * Time: 21:21
 */

namespace Traits;


trait Single
{
    private static $instance = null;
    /**
     * @return static
     */
    public static function getInstance()
    {
        if(is_null(static::$instance)){
            static::$instance = new static();
        }
        return static::$instance;
    }
}