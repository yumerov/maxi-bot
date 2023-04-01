<?php

namespace Yumerov\MaxiBot\Firewalls;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\DTO\EnvDTO;

abstract class AbstractFirewall
{

    public function __construct(
        protected readonly Discord $discord,
        protected readonly Message $message,
        protected readonly LoggerInterface $logger,
        protected readonly EnvDTO $env
    ) {
    }

    abstract public function allow(): bool;
}
