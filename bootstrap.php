<?php

/**
 * Bootstraps the application.
 */

declare(strict_types=1);

use Core\Container;
use Core\Database;
use Core\User;
use JRCS\Post;
use JRCS\Comment;

Container::bind('Core\Database', function() {
    $config = require basePath('config.php');
    return new Database($config['database'], getenv('DB_USER'), getenv('DB_PW') );
});

Container::bind('DatabasePW', function() {
    $config = require basePath('config.php');
    return new Database($config['database'], getenv('PW_USER'), getenv('DB_PW') );
});

Container::bind('JRCS\Comment', function() {
    return new Comment(Container::resolve('Core\Database'));
});

Container::bind('JRCS\Post', function() {
    return new Post(Container::resolve('Core\Database'));
});

Container::bind('Core\User', function($params) {
    $user = new User();

    foreach($params as $key => $value) {
      $user->$key = $value;
    }

    return $user;
});

Container::bind('getUser', function($username) {
    $db = Container::resolve('Core\Database');
    return $db->query(
        'SELECT *
        FROM v_users
        WHERE username = :username',
        [ 'username' => $username ]
    )->findClass('Core\User');
});