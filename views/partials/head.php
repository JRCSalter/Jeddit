<!DOCTYPE html>
<head>
    <title><?= $heading ?></title>
</head>
<html>
    <ul>
        <li><a href="/">Home</a></li>
        <?php if (! Core\Middleware\Auth::isAuth()): ?>
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
        <?php else: ?>
            <form method="POST" action="\login">
                <?php
                view('partials/input.php', [
                    'type'  => 'hidden',
                    'name'  => '_method',
                    'value' => 'DELETE'
                ]);
                view('partials/button.php', [
                    'type'  => 'logout'
                ]);
                ?>
            </form>
        <?php endif ?>
        <li><a href="/about">About</a></li>
    </ul>
</html>
<body>