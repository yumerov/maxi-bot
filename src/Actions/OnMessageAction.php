<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Firewalls\AllowedServerFirewall;
use Yumerov\MaxiBot\Firewalls\NotMeFirewall;

class OnMessageAction
{

    public function __construct(private readonly LoggerInterface $logger, private readonly array $env)
    {
    }

    public function __invoke(Message $message, Discord $discord): void
    {
        if (!(new NotMeFirewall($discord, $message, $this->logger, $this->env))->allow()) {
            return;
        }

        if (!(new AllowedServerFirewall($message, $this->logger, $this->env))->allow()) {
            return;
        }

        if ($message->author->bot) {
            $this->logger->debug('The author is an bot');
            return;
        }

        $mentions = $message->mentions;

        if ($mentions->count() !== 1) {
            $this->logger->debug('More mentioned users than expected');
            return;
        }

        if ($mentions->first()->id !== $discord->user->id) {
            $this->logger->debug("Not matching the user id: (bot){$discord->user->id}<"
                . ">(mentioned){$mentions->first()->id}");
            return;
        }

        $this->logger->debug("OnMessage activated");
        $message->reply('There is no second best!');
    }
}
