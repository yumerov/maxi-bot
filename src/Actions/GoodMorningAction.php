<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\Http\Exceptions\NoPermissionsException;
use Discord\WebSockets\Event;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Exceptions\ExitException;

class GoodMorningAction
{

    private Discord $discord;

    public function __construct(private readonly array $channels, private readonly LoggerInterface $logger)
    {
    }

    /**
     * @throws ExitException
     */
    public function __invoke(Discord $discord): void
    {
        $this->logger->debug('[GM] Bot is ready!');

        if (count($this->channels) === 0) {
            $this->logger->debug('Empty good morning channel list');
            throw new ExitException('Empty good morning channel list');
        }

        $this->discord = $discord;
        $this->sendMessage(0);
    }

    private function sendMessage(int $currentChannelIndex): void
    {
        $channelId = $this->channels[$currentChannelIndex];
        $channel = $this->discord->getChannel($channelId);

        if ($channel === null) {
            $this->logger->debug('Could not find the channel with id ' . $channelId);
            return;
        }

        try {
            $channel
                ->sendMessage('Добро утро, общество!')
                ->always(function () use ($currentChannelIndex) {
                    $currentChannelIndex++;
                    if (!isset($this->channels[$currentChannelIndex])) {
                        $this->logger->debug('Reached the end of channel list');
                        throw new ExitException('Reached the end of channel list');
                    }

                    $this->sendMessage($currentChannelIndex);
                });
        } catch (NoPermissionsException $ex) {
            $this->logger->error($ex->getMessage());
        }
    }
}
