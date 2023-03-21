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

        $discord->getChannel('1078284556773380186')->sendMessage('Добро утро, общество :)');

//        $discord->on(Event::MESSAGE_CREATE, new OnMessageAction());
    }
}
