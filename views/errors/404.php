<?php

declare(strict_types=1);

require(basePath('views/partials/head.php'));

?>

<h1>404. Not found.</h1>

<p><?= isset($message) ? $message : "The server could not complete the request" ?></p>