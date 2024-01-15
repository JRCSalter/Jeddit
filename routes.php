<?php

/**
 * Defines all the routes available to the application.
 */

declare(strict_types=1);

$router->get('/', 'controllers/index.php');

$router->get('/about', 'controllers/about.php');

// POST
$router->get('/post', 'controllers/post/show.php');
$router->get('/post/create', 'controllers/post/create.php')
    ->auth();
$router->post('/post', 'controllers/post/store.php')
    ->auth();

// LOGIN
$router->get('/login',  'controllers/login/create.php')
    ->guest();

$router->post('/login', 'controllers/login/store.php')
    ->guest();

$router->delete('/login', 'controllers/login/destroy.php')
    ->auth();

// REGISTER
$router->get('/register', 'controllers/register/create.php')
    ->guest();

$router->post('/register', 'controllers/register/store.php')
    ->guest();

// COMMENT
$router->post('/comment', 'controllers/comment/store.php')
    ->auth();