<?php

declare(strict_types=1);

use Core\Container;
use Core\Session;

require(basePath('views/partials/head.php'));

$user = Container::resolve( 'getUser', Session::get('username'));
?>

<h1><?= $heading; ?></h1>

<form method="POST" action="/post" >
    <?php
    if (isset($errors['new_post'])) echo $errors['new_post'];
    view('partials/input.php', [
        'value' => $title ?? 'Title',
        'type'  => 'text',
        'name'  => 'Title'
    ]);
    if (isset($errors['title'])) echo $errors['title'];

    view('partials/textarea.php', [
        'value' => $content ?? 'Content',
        'name'  => 'Content'
    ]);
    if (isset($errors['content'])) echo $errors['content'];

    view('partials/input.php', [
        'value' => $user->id ?? NULL,
        'type'  => 'hidden',
        'name'  => 'user_id'
    ]);

    view('partials/button.php', [
        'type'  => 'Submit'
    ]);
    ?>
</form>

<?php
require(basePath('views/partials/foot.php'));
