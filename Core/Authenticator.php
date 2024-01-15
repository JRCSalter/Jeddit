<?php

declare(strict_types=1);

namespace Core;

use Core\Container;

/**
 * Contains methods to authenticate a users details.
 */
class Authenticator
{
    /**
     * Attempts a login.
     * 
     * Returns true if successful, false if not.
     * 
     * @param string $username The username to check.
     * @param string $password The password to check.
     * 
     * @return bool
     */
    public function attempt(string $username, string $password): bool
    {
        $user = Container::resolve('DatabasePW')->query(
            'SELECT * FROM users WHERE username = :username',
            [
                'username' => $username,
            ]
        )->find();

        if (! $user) return false;

        if (! password_verify($password, $user['password'])) return false;

        $this->login([
            'username' => $username,
        ]);

        return true;
    }

    /**
     * Logs a user in.
     * 
     * @param array $user An array of details to enter into $_SESSION.
     * 
     * @return void
     */
    public function login(array $user): void
    {
        $_SESSION['username'] = $user['username'];

        session_regenerate_id(true);
    }

    /**
     * Logs the user out of the site.
     * 
     * @return void
     */
    public function logout(): void
    {
        Session::destroy();
    }
}