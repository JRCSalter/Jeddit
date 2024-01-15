<?php

declare(strict_types=1);

namespace Core;

/**
 * Defines a service container to bind functions to.
 */
class Container {
    /** @var array The collection of bindings. */
    private static array $bindings = [];

    /**
     * Binds a function to the container.
     * 
     * @param string   $key      The key to identify the binding.
     * @param callable $resolver The function to call when resolved.
     * 
     * @return void
     */
    public static function bind(string $key, callable $resolver ): void
    {
        static::$bindings[$key] = $resolver;
    }

    /**
     * Resovles the binding.
     * 
     * @param string $key The identifier of the binding.
     * @param array|string $params Any parameters to pass to the binding.
     * 
     * @throws \Exception If the binding does not exist.
     * 
     * @return mixed
     */
    public static function resolve(string $key, array|string $params = [] ): mixed
    {
        if (! array_key_exists($key, static::$bindings)) {
            throw new \Exception("No matching binding found for {$key}");
        }
 
        $resolver = static::$bindings[$key];

        return call_user_func($resolver, $params);
    }
}