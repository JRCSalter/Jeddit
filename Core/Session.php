<?php

namespace Core;

/**
 * Controls the session.
 */
class Session
{
    /**
     * Checks whether a key exists.
     * 
     * @param string $key The key to search for.
     * 
     * @return bool
     */
    public static function has(string $key): bool
    {
        return (bool) static::get($key);
    }

    /**
     * Enters, or chacnges a key-value pair in $_SESSION.
     * 
     * @param string $key   The key.
     * @param string $value The value.
     * 
     * @return void
     */
    public static function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a key and supply a default if not available.
     * 
     * @param string $key The key to get.
     * @param string $default Specify a default if the key is not set.
     *     Defaults to NULL.
     * 
     * @return string
     */
    public static function get(string $key, string $default = NULL): mixed
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    /**
     * Flashes a value to $_SESSION.
     * 
     * @param string $key   The key.
     * @param string $value The value.
     * 
     * @return void
     */
    public static function flash(string $key, string $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * Removes any flashed values.
     * 
     * @return void
     */
    public static function unflash(): void
    {
       unset($_SESSION['_flash']);
    }

    /**
     * Removes all data from $_SESSION.
     * 
     * @return void
     */
    public static function flush(): void
    {
        $_SESSION = [];
    }

    /**
     * Destroys the session.
     * 
     * @return void
     */
    public static function destroy(): void
    {
        static::flush();

        session_destroy();

        $params = session_get_cookie_params();
        setcookie(
            'PHPSESSID',
            '',
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
}