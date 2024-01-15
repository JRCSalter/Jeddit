<?php

/**
 * This is a file containing some useful functions
 */

declare(strict_types=1);

/**
 * Dumps the value of a variable, formatted in a readable way, then terminates
 * the script.
 * 
 * @param mixed $value The value to be printed.
 * 
 * @return void
 */
function dd(mixed $value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

/**
 * Checks whether the given URL is the current one.
 * 
 * @param string $value The URL to check.
 * 
 * @return bool
 */
function urlIs(string $value): bool
{
    return $_SERVER['REQUEST_URI'] === $value;
}

/**
 * Gets the full file path of the given directory.
 * 
 * @param string $path The path to inspect.
 * 
 * @return string
 */
function basePath(string $path): string
{
    return BASE_PATH . $path;
}

/**
 * Displays a view from the given path.
 * 
 * @param string $path       The file path of the view to be displayed.
 * @param array  $attributes A list of attributes to be passed to the view.
 *     Defaults to an empty array.
 * 
 * @return void
 */
function view($path, $attributes = []): void
{
    extract($attributes);

    require basePath('views/' . $path);
}

/**
 * Aborts the script with the given status code.
 * 
 * @param Core\Response $status The status code to be used.
 *     Defaults to NOT_FOUND.
 * 
 * @return void
 */
function abort(int $status = Core\Response::NOT_FOUND, array $attributes = []): void
{
    http_response_code((int) $status);
    view("errors/{$status}.php", $attributes);
    die();
}

/**
 * Aborts the script if the given condition is not met.
 * 
 * @param bool          $condition The condition to check.
 * @param Core\Response $status    The status to be returned should the
 *     comparison fail.
 *     Defaults to FORBIDDEN.
 * 
 * @return void
 */
function authorise(
    bool $condition,
    Core\Response $status = Core\Response::FORBIDDEN
): void {
    if (! $condition) {
        abort($status);
    }
}

/**
 * Logs the user in to the session.
 * 
 * @param Core\User $user The user to be added.
 * 
 * @return void
 */
function login(Core\User $user): void
{
    $_SESSION['user'] = [
        'email'    => $user->email    ?? NULL,
        'username' => $user->username ?? NULL,
    ];

    session_regenerate_id(TRUE);
}

/**
 * Logs out the user from the session.
 * 
 * @return void
 */
function logout(): void
{
    $params = session_get_cookie_params();

    $_SESSION = [];
    session_destroy();

    // Deletes the PHPSESSID cookie.
    setcookie(
        'PHPSESSID',
        '',
        time() - 3600,
        $params[ 'path'     ],
        $params[ 'domain'   ],
        $params[ 'secure'   ],
        $params[ 'httponly' ]
    );
}

/**
 * Redirects the user to the specified URL and exits the script.
 * 
 * @param string $path The URL to redirect to.
 *     Defaults to '/'
 * 
 * @return void
 */
function redirect(string $path = '/'): void
{
    header("location: {$path}");
    exit();
}