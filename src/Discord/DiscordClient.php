<?php

namespace Yumerov\MaxiBot\Discord;

use Discord\Discord;

class DiscordClient
{
    public function __construct(
        protected readonly Discord $discord,
        protected $onReadyAction
    ) {
    }

    public function run(): void
    {
        $this->discord->on('ready', $this->onReadyAction);

        $this->discord->run();
    }
}
