<?php

declare(strict_types=1);

namespace Core\Middleware;

/**
 * Defines the Guest middleware.
 */
class Guest {
    /**
     * Checks if the user is not authorised.
     * 
     * @return bool
     */
    public static function isGuest(): bool
    {
        return ! isset($_SESSION['name']) ? TRUE : FALSE;
    }

    /**
     * Checks if the user is a guest.
     * 
     * Redirects to HOME if not a guest.
     * 
     * @return void
     */
    public function handle(): void
    {
        if (! $this->isGuest()) {
            header('location: ' . getenv('HOME'));
            exit();
      }
    }
}