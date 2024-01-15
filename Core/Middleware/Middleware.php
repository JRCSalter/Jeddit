<?php

declare(strict_types=1);

namespace Core\Middleware;

/**
 * Defines the middleware.
 */
class Middleware
{
    /** @var array Defines the various pieces of middleware allowed. */
    const MAP = [
        'guest' => Guest::class,
        'auth'  => Auth::class
    ];

    /**
     * Resolves the middleware
     * 
     * @param ?string $key The Key to resolve.
     * 
     * @throws \Exception if middleware cannot be found.
     * 
     * @return void
     */
    public static function resolve(?string $key): void
    {
        if(! $key) return;

        $middleware = static::MAP[$key] ?? FALSE;

        if(! $middleware) throw new \Exception("No middleware found for key: {$key}");

        (new $middleware)->handle($key);
    }
}