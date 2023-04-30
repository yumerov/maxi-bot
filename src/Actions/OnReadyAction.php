<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\WebSockets\Event;
use Exception;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Commands\CommandHandlerInterface;

class OnReadyAction
{

    public function __construct(
        private readonly OnMessageAction $action,
        private readonly CommandHandlerInterface $commandHandler,
        private readonly LoggerInterface $logger
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Discord $discord): void
    {
        $this->logger->debug("Bot is ready!");

        $this->commandHandler->iterate($discord);

        $discord->on(Event::MESSAGE_CREATE, $this->action);
    }
}
