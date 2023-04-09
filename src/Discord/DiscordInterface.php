<?php

namespace Yumerov\MaxiBot\Discord;

interface DiscordInterface
{

    public function setOnReadyAction(callable $action): void;
    public function run(): void;
}
