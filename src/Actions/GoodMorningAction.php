<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\Http\Exceptions\NoPermissionsException;
use Discord\WebSockets\Event;
use Psr\Log\LoggerInterface;

class GoodMorningAction
{

    private Discord $discord;

    public function __construct(private readonly array $channels, private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(Discord $discord): void
    {
        $this->logger->debug("[GM] Bot is ready!");

        if (count($this->channels) === 0) {
            $this->logger->debug("Empty good morning channel list");
            exit;
        }

        $this->discord = $discord;
        $this->sendMessage(0);
    }

    private function sendMessage(int $currentChannelIndex): void
    {
        $channelId = $this->channels[$currentChannelIndex];
        $channel = $this->discord->getChannel($channelId);

        if ($channel !== null) {
            try {
                $channel
                    ->sendMessage('Добро утро, общество!')
                    ->always(function () use ($currentChannelIndex) {
                        $currentChannelIndex++;
                        if (!isset($this->channels[$currentChannelIndex])) {
                            $this->logger->debug('Reached the end of channel list');
                            exit(0);
                        }

                        $this->sendMessage($currentChannelIndex);
                    });
            } catch (NoPermissionsException $ex) {
                $this->logger->error($ex->getMessage());
            }
        } else {
            $this->logger->debug('Could not find the channel with id ' . $channelId);
        }
    }
}
