<?php

declare(strict_types=1);

require(basePath('views/partials/head.php'));

?>

<h1>403. Not authorised.</h1>

<p><?= isset($message) ? $message : "The server could not complete the request" ?></p>