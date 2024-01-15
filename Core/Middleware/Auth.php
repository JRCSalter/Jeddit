<?php

declare(strict_types=1);

namespace Core\Middleware;

/**
 * Defines the Auth middleware.
 */
class Auth {
    /**
     * Checks if the user is authorised.
     * 
     * @return bool
     */
    public static function isAuth(): bool
    {
        return isset($_SESSION['username']) ? TRUE : FALSE;
    }

    /**
     * Checks if user is authorised.
     * 
     * Redirects to HOME if not a authorised.
     * 
     * @return void
     */
    public function handle(): void
    {
        if (! $this->isAuth()) {
            redirect();
            exit();
        }
    }
}