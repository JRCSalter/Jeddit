<?php

declare(strict_types=1);

namespace Core;

/**
 * Defines a set of HTTP response codes
 */
enum Response
{  
    /** @var int The URL cannot be found. */
    public const NOT_FOUND = 404;

    /** @var int The URL is forbidden to the current user. */
    public const FORBIDDEN = 403;
    
    /** @var int The server cannot handle the request. */
    public const NOT_IMPLEMENTED = 501;
}