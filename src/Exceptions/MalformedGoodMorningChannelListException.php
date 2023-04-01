<?php

namespace Yumerov\MaxiBot\Exceptions;

use Throwable;

class MalformedGoodMorningChannelListException extends Exception
{

    public function __construct(string $message = "Malformed good morning channel list", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
