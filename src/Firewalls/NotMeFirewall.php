<?php

namespace Yumerov\MaxiBot\Firewalls;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;

class NotMeFirewall extends AbstractFirewall
{

    public function __construct(
        private readonly Discord $discord,
        Message $message,
        LoggerInterface $logger,
        array $env
    ) {
        parent::__construct($message, $logger, $env);
    }

    public function allow(): bool
    {
        if ($this->message->author === null) {
            return true;
        }

        if ($this->message->author->id === $this->discord->user->id) {
            return false;
        }

        return true;
    }
}
