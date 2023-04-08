<?php

namespace Yumerov\MaxiBot\Pipeline;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;

abstract class AbstractStep implements StepInterface
{

    protected Discord $discord;
    protected Message $message;

    public function __construct(protected readonly LoggerInterface $logger)
    {
    }

    public function setDiscord(Discord $discord): static
    {
        $this->discord = $discord;
        return $this;
    }

    public function setMessage(Message $message): static
    {
        $this->message = $message;
        return $this;
    }
}
