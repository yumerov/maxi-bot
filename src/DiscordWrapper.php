<?php

namespace Yumerov\MaxiBot;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;
use Yumerov\MaxiBot\Actions\OnReadyAction;

class DiscordWrapper
{
    public function __construct(private readonly Discord $discord)
    {
    }

    public function run(): void
    {
        $this->discord->on('ready', new OnReadyAction());

        $this->discord->run();
    }
}
