<?php

namespace Yumerov\MaxiBot\Firewalls;

use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;

abstract class AbstractFirewall
{

    public function __construct(
        protected readonly Message $message,
        protected readonly LoggerInterface $logger,
        protected readonly array $env
    ) {
    }

    abstract public function allow(): bool;
}
