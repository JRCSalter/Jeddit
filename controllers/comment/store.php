<?php

declare(strict_types=1);

use Core\Container;
use Core\Session;
use Core\Validator;

$db = Container::resolve(Core\Database::class);

$content = $_POST['content'] ?? '';
$userId  = $_POST['user_id'] ?? '';
$postId  = $_POST['post_id'] ?? '';

if (
    ! Validator::isString(
        $content,
        (int) getenv('COMMENT_MIN'),
        (int) getenv('COMMENT_MAX')
    )
) {
    $errors['content'] =
        'Please provide content between ' .
        getenv('COMMENT_MIN') .
        ' and ' .
        getenv('COMMENT_MAX');
}

if (! empty($errors)) {
    view('post/show.php', [
        'content' => $content,
        'id'      => (int) $postId,
        'heading' => 'Post',
        'errors'  => $errors,
    ]);

    exit();
}

Session::flash('message', 'You have successfully posted a comment');

$data = [
    'content' => $content,
    'user_id' => $userId,
    'post_id' => $postId,
];

$db->insert('comments', $data, JRCS\Comment::class);

redirect('/post?id=' . $postId);