<?php

declare(strict_types=1);

use Core\Authenticator;
use Core\Container;
use Core\Session;
use Core\Middleware\Auth;

$db = Container::resolve('Core\Database');

$posts = $db->query(
    "SELECT
        p.id,
        p.title,
        u.username
    FROM v_posts p
    INNER JOIN
    v_users u
    ON p.user_id = u.id"
)->getClass("JRCS\Post");

require('partials/head.php');

?>

<h1><?= $heading ?></h1>

<?php if (Auth::isAuth()) : ?>
<a href="/post/create">Create a post</a>
<?php endif ?>

<p>
    <?php foreach ($posts as $post): ?>
        <a href="/post?id=<?= $post->id ?>"><?= $post->title ?></a><br>
    <?php endforeach ?>
</p>

<?php
require('partials/foot.php');