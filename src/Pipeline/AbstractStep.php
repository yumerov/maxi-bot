<?php

namespace Yumerov\MaxiBot\Pipeline;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\DTO\EnvDTO;

class AbstractStep
{

    public function __construct(
        protected readonly Discord $discord,
        protected readonly Message $message,
        protected readonly LoggerInterface $logger,
        protected readonly EnvDTO $env
    ) {
    }
}
