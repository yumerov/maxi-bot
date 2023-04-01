<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\DTO\EnvDTO;
use Yumerov\MaxiBot\Firewalls\AbstractFirewall;
use Yumerov\MaxiBot\Firewalls\AllowedServerFirewall;
use Yumerov\MaxiBot\Firewalls\MaintainerOnlyMode;
use Yumerov\MaxiBot\Firewalls\NotMeFirewall;

class OnMessageAction
{

    /**
     * @var AbstractFirewall[]
     */
    private array $firewalls;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly EnvDTO $env
    ) {
    }

    private function initFirewalls(Message $message, Discord $discord): void
    {
        $this->firewalls = [
            new NotMeFirewall($discord, $message, $this->logger, $this->env),
            new AllowedServerFirewall($discord, $message, $this->logger, $this->env),
            new MaintainerOnlyMode($discord, $message, $this->logger, $this->env),
        ];
    }

    public function __invoke(Message $message, Discord $discord): void
    {
        $this->initFirewalls($message, $discord);

        foreach ($this->firewalls as $firewall) {
            if (!$firewall->allow()) {
                return;
            }
        }

        $message->reply('There is no second best!');
    }
}
