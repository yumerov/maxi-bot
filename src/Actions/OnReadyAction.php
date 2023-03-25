<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\WebSockets\Event;
use Monolog\Logger;

class OnReadyAction
{

    public function __construct(private readonly OnMessageAction $action, private readonly Logger $logger)
    {
    }

    public function __invoke(Discord $discord): void
    {
        $this->logger->debug("Bot is ready!");

        $discord->on(Event::MESSAGE_CREATE, $this->action);
    }
}
