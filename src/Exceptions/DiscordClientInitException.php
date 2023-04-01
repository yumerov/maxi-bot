<?php

namespace Yumerov\MaxiBot\Exceptions;

use Throwable;

class DiscordClientInitException extends Exception
{

    public function __construct(
        string $message = "Failed to init Discord client",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
