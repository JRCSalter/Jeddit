<?php

declare(strict_types=1);

use Core\Container;
use Core\Middleware\Auth;
use Core\Session;

require(basepath('views/partials/head.php'));

$db       = Container::resolve('Core\Database');
$comments = Container::resolve('JRCS\Comment')->getAllForPost($id);
$post     = Container::resolve('JRCS\Post')->get($id);

?>

<h1><?= $post->title ?></h1>

<p>
    <?= $post->content ?>
</p>

<?php foreach($comments as $comment): ?>
    <p><?= $comment->content ?>
    <small><i>by</i> <?= $comment->author() ?></small>
<?php endforeach ?>

<?php if( Auth::isAuth() ): 

$user = Container::resolve( 'getUser', Session::get('username'));

?>

<h2>Reply</h2>
<form method="POST" action="/comment">
    <label for="content">Your Comment:</label>
    <?php
    if (isset($errors['content'])) echo $errors['content'];
    ?>



    <textarea name="content" id = "content"><?= $content ?? '' ?></textarea>
    <input type="hidden" value="<?= $post->id ?>" name="post_id" id="post_id">
    <input type="hidden" value="<?= $user->id ?>" name="user_id" id="user_id">
    <button type="submit">Submit</button>
</form>

<?php else: ?>
    <p>Sign in to comment</p>
<?php endif ?>

<?php
require(basepath('views/partials/foot.php'));