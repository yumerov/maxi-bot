<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Traits\HasDiscordTrait;

abstract class AbstractStep implements StepInterface
{
    use HasDiscordTrait;

    protected Discord $discord;
    protected Message $message;

    public function __construct(protected readonly LoggerInterface $logger)
    {
    }

    public function setMessage(Message $message): static
    {
        $this->message = $message;
        return $this;
    }
}
