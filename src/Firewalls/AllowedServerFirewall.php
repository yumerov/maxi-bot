<?php

namespace Yumerov\MaxiBot\Firewalls;

class AllowedServerFirewall extends AbstractFirewall
{

    public function allow(): bool
    {
        $allowedServers = json_decode($this->env->allowedServers);
        if ($allowedServers === null) {
            $this->logger->critical('Malformed value in env');
            return false;
        }

        if (empty($allowedServers)) {
            $this->logger->debug('Allowed server list is empty');
            return false;
        }

        $serverId = $this->message->channel->guild_id;
        $maintainer = $this->env->maintainer;
        if (!in_array($serverId, $allowedServers)) {
            $this->logger->warning("The server with id '{$serverId}' is not in allowed list");
            $this->message->reply('This server is not in allowed list. Please z tip and DM <@' . $maintainer . '>');
            return false;
        }

        return true;
    }
}
