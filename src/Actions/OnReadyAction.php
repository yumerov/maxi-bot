<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;

class OnReadyAction
{

    public function __invoke(Discord $discord): void
    {
        echo "Bot is ready!", PHP_EOL; // todo: replace with monolog

        $discord->on(Event::MESSAGE_CREATE, new OnMessageAction());
    }
}
