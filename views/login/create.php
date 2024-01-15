<?php

declare(strict_types=1);

require(basePath('views/partials/head.php'));

?>

<h1><?= $heading; ?></h1>

<form method="POST" action="/login" >
    <?php
    if (isset($errors['sign_in'])) echo $errors['sign_in'];
    view('partials/input.php', [
        'value' => $username ?? 'Username',
        'type'  => 'text',
        'name'  => 'Username'
    ]);
    if (isset($errors['username'])) echo $errors['username'];

    view('partials/input.php', [
        'value' => '',
        'type'  => 'password',
        'name'  => 'Password'
    ]);
    if (isset($errors['password'])) echo $errors['password'];

    view('partials/button.php', [
        'type'  => 'Submit'
    ]);
    ?>
</form>

<?php
require(basePath('views/partials/foot.php'));