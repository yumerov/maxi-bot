<?php

namespace Yumerov\MaxiBot\Discord;

use Yumerov\MaxiBot\Exceptions\ExitException;

interface DiscordInterface
{

    public function setOnReadyAction(callable $action): void;

    /**
     * @return void
     * @throws ExitException
     */
    public function run(): void;
}
