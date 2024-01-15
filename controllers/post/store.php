<?php

declare(strict_types=1);

use Core\Container;
use Core\Session;
use Core\Validator;


$db = Container::resolve(Core\Database::class);

$content = $_POST['content'] ?? '';
$title   = $_POST['title']   ?? '';
$userId  = $_POST['user_id'] ?? '';

if (
    ! Validator::isString(
        $content,
        (int) getenv('POST_MIN') ?? 1,
        (int) getenv('POST_MAX') ?? 65025
    )
) {
    $errors['content'] =
        'Please provide content between ' .
        getenv('POST_MIN') ?? 1 .
        ' and ' .
        getenv('POST_MAX') ?? 65025;
}

if (
    ! Validator::isString(
        $title,
        (int) getenv('POST_TITLE_MIN') ?? 1,
        (int) getenv('POST_TITLE_MAX') ?? 255
    )
) {
    $errors['title'] =
        'Please provide a title between ' .
        getenv('POST_TITLE_MIN') ?? 1 .
        ' and ' .
        getenv('POST_TITLE_MAX') ?? 255;
}


if (! empty($errors)) {
    view('post/create.php', [
        'content' => $content,
        'title'   => $title,
        'heading' => 'Create a Post',
        'errors'  => $errors,
    ]);

    exit();
}

Session::flash('message', 'You have successfully created a post');

$data = [
    'content' => $content,
    'title'   => $title,
    'user_id' => $userId,
];

$db->insert('posts', $data, JRCS\Post::class);

redirect();
//redirect('/post?id=' . $postId);
