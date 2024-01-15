<?php

declare(strict_types=1);

require(basePath('views/partials/head.php'));

?>

<h1><?= $heading; ?></h1>

<form method="POST" action="/register" >
    <?php

    if (isset($errors['general'])) echo $errors['general'];

    view('partials/input.php', [
        'value' => $firstName ?? 'First Name',
        'type'  => 'text',
        'name'  => 'First Name'
    ]);
    if (isset($errors['first_name'])) echo $errors['first_name'];
    
    view('partials/input.php', [
        'value' => $lastName ?? 'Last Name',
        'type'  => 'text',
        'name'  => 'Last Name'
    ]);
    if (isset($errors['last_name'])) echo $errors['last_name'];
  
    view('partials/input.php', [
        'value' => $username ?? 'Username',
        'type'  => 'text',
        'name'  => 'Username'
    ]);
    if (isset($errors['username'])) echo $errors['username'];

    view('partials/input.php', [
        'value' => $email ?? 'Email',
        'type'  => 'email',
        'name'  => 'Email'
    ]);
    if (isset($errors['email'])) echo $errors['email'];

    view('partials/input.php', [
        'value' => $birthday ?? date('Y-m-d', time()),
        'type'  => 'date',
        'name'  => 'Birthday'
    ]);
    if (isset($errors['birthday'])) echo $errors['birthday'];

    view('partials/input.php',  [
        'value' => '',
        'type'  => 'password',
        'name'  => 'Password'
    ]);
    if (isset($errors['password'])) echo $errors['password'];

    view('partials/input.php',  [
        'value' => '',
        'type'  => 'password',
        'name'  => 'Password Check'
    ]);
    if (isset($errors['password_check'])) echo $errors['password_check'];

    view('partials/button.php', [
        'type'  => 'Submit'
    ]);
  
  ?>
</form>

<?php
require(basePath('views/partials/foot.php'));
