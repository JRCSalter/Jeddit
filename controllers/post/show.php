<?php

declare(strict_types=1);

view('post/show.php', [
  'id' => (int) $_GET[ 'id' ] ?? NULL
]);