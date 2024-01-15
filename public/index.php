<?php

/**
 * This is the landing page for the site.
 * 
 * It gets the uri and performs actions based on the value.
 */

declare(strict_types=1);

use Core\Session;
use Core\Container;

session_start();

const BASE_PATH = __DIR__ . '/../';

// Converts namespaces into a require statement
spl_autoload_register(function($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require basePath($class . '.php');
});

require BASE_PATH . 'Core/functions.php';

// Set the environment variables
$envFile = file(basePath('.env'), FILE_IGNORE_NEW_LINES);

foreach ($envFile as $line) {
    if ($line == "") continue;
    if (strpos($line, '//') === 0) continue;
    putenv($line);
}

require basePath('bootstrap.php');

$uri    = parse_url($_SERVER['REQUEST_URI'])['path'];
$router = new Core\Router();
$routes = require basePath('routes.php');
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

// Not sure if this is the done thing, but I figure if I regenerate the ID every
// time a page is loaded, then there is less chance of it being able to used if
// stolen.
if(Session::get('username')) {
    session_regenerate_id(true);
}

echo Session::get('message');
echo Session::get('errors');

$router->route($uri, $method);

Session::unflash();