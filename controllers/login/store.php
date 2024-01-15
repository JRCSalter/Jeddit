<?php

declare(strict_types=1);

use Core\Validator;
use Core\Authenticator;
use Core\Session;
use Core\Container;

$db = Container::resolve('Core\Database');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (
    ! Validator::isString(
        $password,
        (int) getenv('PASSWORD_MIN'),
        (int) getenv('PASSWORD_MAX')
    )
) {
    $errors['password'] = 'Please provide a valid password.';
}

if (! Validator::isString($username)) {
    $errors['username'] = 'Please provide a valid username.';
}

$signedIn = (new Authenticator)->attempt($username, $password);

if (! $signedIn) {
    $errors['sign_in'] = 'No user found matching those credentials.';
}

if(! empty($errors)) {
    view('login/create.php', [
        'username' => $username,
        'heading'  => 'Login',
        'errors'   => $errors,
    ]);
    exit();
}

Session::flash('message', 'You have succesfully logged in.');

Session::put(
    'user',
    $db->query(
        'SELECT * FROM v_users WHERE username = :username',
        ['username' => Session::get('username')])->findClass(Core\User::class
    )
);

redirect();