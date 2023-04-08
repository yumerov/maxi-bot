<?php

namespace Yumerov\MaxiBot\Pipeline;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;

class AbstractStep
{

    protected Discord $discord;
    protected Message $message;

    public function __construct(protected readonly LoggerInterface $logger)
    {
    }

    public function setDiscord(Discord $discord): AbstractStep
    {
        $this->discord = $discord;
        return $this;
    }

    public function setMessage(Message $message): AbstractStep
    {
        $this->message = $message;
        return $this;
    }
}
