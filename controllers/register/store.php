<?php

declare(strict_types=1);

use Core\Authenticator;
use Core\Container;
use Core\Validator;
use Core\Session;

$db = Container::resolve('Core\Database');

$data = [
    'first_name'     => $_POST['first_name'] ?? '',
    'last_name'      => $_POST['last_name'] ?? '',
    'username'       => $_POST['username'] ?? '',
    'email'          => $_POST['email'] ?? '',
    'birthday'       => $_POST['birthday'] ?? '',
    'password'       => $_POST['password'] ?? '',
    'password_check' => $_POST['password_check'] ?? '',
];

if (! Validator::isString($data['first_name'])) {
    $errors['first_name'] =
        'Please provide a name between 1 and 255 characters';
}

if (! Validator::isString($data['last_name'])) {
    $errors['last_name'] =
        'Please provide a name between 1 and 255 characters';
}

if (! Validator::isString($data['username'])) {
    $errors['username'] =
        'Please provide a name between 1 and 255 characters';
}

if (! Validator::isEmail($data['email'])) {
    $errors['email'] =
        'Please provide a valid email address';
}

if (
    ! Validator::isString(
        $data['password'],
        (int) getenv('PASSWORD_MIN'),
        (int) getenv('PASSWORD_MAX')
    )
) {
    $errors['password'] =
        'Please provide a password between ' .
        getenv('PASSWORD_MIN') .
        ' and ' .
        getenv('PASSWORD_MAX') .
        ' characters.';
}

if ($data['password'] !== $data['password_check']) {
    $errors['password_check'] =
        'The passwords do not match';
}

$originalPW = $data['password'];
$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

$user = $db->query(
    'SELECT *
    FROM v_users
    WHERE username = :username
    OR email = :email',
    [
        'username' => $data['username'],
        'email'    => $data['email'],
    ]
)->find();

if ($user) {
    $errors['general'] =
        "User already exists with those details.";
}

if (! empty($errors)) {
    view('register/create.php', [
        'data'  => $data,
        'errors'    => $errors,
        'heading'   => 'Register',
    ]);
    exit();
}

// This is not needed for the following insert method, and will cause an error.
// I could sort it out automatically, but at that point, I'm basically building
// a framework.
unset($data['password_check']);

$user = $db->insert('users', $data);

Session::flash(
    'message',
    'You have succesfully registered. Welcome ' . $user->username . '.'
);

(new Authenticator)->attempt($user->username, $originalPW);

redirect();
exit();