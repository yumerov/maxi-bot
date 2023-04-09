<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

use Psr\Log\LoggerInterface;

class AllowedServerFirewallStep extends AbstractFirewall
{

    public function __construct(
        protected readonly LoggerInterface $logger,
        protected readonly array $allowedServers,
        protected readonly string $maintainer
    ) {
    }

    public function allow(): bool
    {
        if (empty($this->allowedServers)) {
            $this->logger->debug('Allowed server list is empty');
            return false;
        }

        $serverId = $this->message->channel->guild_id;
        if (!in_array($serverId, $this->allowedServers)) {
            $this->logger->warning("The server with id '$serverId' is not in allowed list");
            $this->message->reply("This server is not in allowed list. Please z tip and DM <@$this->maintainer>");
            return false;
        }

        return true;
    }
}
