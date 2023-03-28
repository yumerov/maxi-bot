<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\WebSockets\Event;
use Psr\Log\LoggerInterface;

class OnReadyAction
{

    public function __construct(private readonly OnMessageAction $action, private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(Discord $discord): void
    {
        $this->logger->debug("Bot is ready!");

        $discord->on(Event::MESSAGE_CREATE, $this->action);
    }
}
