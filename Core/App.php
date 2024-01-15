<?php

namespace Core;

// I'm still unclear why this class even exists,
// but I'm keeping it in case I find a use for it.

class App
{
    private static $container;
  
    public static function setContainer($container)
    {
        static::$container = $container;
    }
  
    public static function container()
    {
        return static::$container;
    }
  
    public static function bind($key, $resolver)
    {
        return static::container()->bind($key, $resolver);
    }
  
    public static function resolve($key)
    {
        return static::container()->resolve($key);
    }
}