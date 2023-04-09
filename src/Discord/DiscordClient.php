<?php

namespace Yumerov\MaxiBot\Discord;

use Discord\Discord;

class DiscordClient implements DiscordInterface
{
    /**
     * @var callable
     */
    protected $onReadyAction;

    public function __construct(
        protected readonly Discord $discord,
    ) {
    }

    public function setOnReadyAction(callable $action): void
    {
        $this->onReadyAction = $action;
    }

    public function run(): void
    {
        $this->discord->on('ready', $this->onReadyAction);

        $this->discord->run();
    }
}
