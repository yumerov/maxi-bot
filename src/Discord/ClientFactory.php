<?php

namespace Yumerov\MaxiBot\Discord;

use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\WebSockets\Intents;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\DiscordClient;
use Yumerov\MaxiBot\Exceptions\DiscordClientInitException;

class ClientFactory
{

    /**
     * @throws DiscordClientInitException
     */
    public function create(
        string $token,
        LoggerInterface $logger,
        callable $onReadyAction
    ): DiscordClient {
        try {
            return new DiscordClient(
                $this->getDiscord($token, $logger),
                $onReadyAction
            );
        } catch (IntentException $ex) {
            throw new DiscordClientInitException(previous: $ex);
        }
    }

    /**
     * @param string $token
     * @param LoggerInterface $logger
     * @return Discord
     * @throws IntentException
     */
    private function getDiscord(string $token, LoggerInterface $logger): Discord
    {
        return new Discord([
            'token' => $token,
            'intents' => Intents::getDefaultIntents(),
            'logger' => $logger
        ]);
    }
}
