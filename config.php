<?php

/**
 * Defines the configuration settings.
 */

return [
    'database' => [
        'host'    => getenv( 'DB_HOST'    ) ?? 'localhost',
        'dbname'  => getenv( 'DB_NAME'    ) ?? 'jrcsalter',
        'charset' => getenv( 'DB_CHARSET' ) ?? 'utf8mb4'
    ],
];