<?php

namespace Yumerov\MaxiBot\Pipeline;

use Discord\Discord;
use Discord\Parts\Channel\Message;

interface StepInterface
{

    public function execute(): void;
    public function stops(): bool;
    public function setDiscord(Discord $discord): static;
    public function setMessage(Message $message): static;
}
