<?php

namespace Yumerov\MaxiBot\Pipeline;

use Psr\Log\LoggerInterface;

class AllowedServerFirewallStep extends AbstractFirewall
{

    public function __construct(
        protected readonly LoggerInterface $logger,
        protected readonly string $allowedServers,
        protected readonly string $maintainer
    ) {
    }

    public function allow(): bool
    {
        $allowedServers = json_decode($this->allowedServers);
        if ($allowedServers === null) {
            $this->logger->critical('Malformed value in env');
            return false;
        }

        if (empty($allowedServers)) {
            $this->logger->debug('Allowed server list is empty');
            return false;
        }

        $serverId = $this->message->channel->guild_id;
        if (!in_array($serverId, $allowedServers)) {
            $this->logger->warning("The server with id '$serverId' is not in allowed list");
            $this->message->reply("This server is not in allowed list. Please z tip and DM <@$this->maintainer>");
            return false;
        }

        return true;
    }
}
