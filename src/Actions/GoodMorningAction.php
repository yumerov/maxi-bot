<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\Http\Exceptions\NoPermissionsException;
use Discord\WebSockets\Event;

class GoodMorningAction
{

    private Discord $discord;

    public function __construct(private readonly array $channels)
    {
    }

    public function __invoke(Discord $discord): void
    {
        echo "[GM] Bot is ready!", PHP_EOL; // todo: replace with monolog

        if (count($this->channels) === 0) {
            // log
            exit;
        }

        $this->discord = $discord;
        $this->sendMessage(0);
    }

    private function sendMessage(int $currentChannelIndex): void
    {
        $channel = $this->discord->getChannel($this->channels[$currentChannelIndex]);

        if ($channel !== null) {
            try {
                $channel
                    ->sendMessage('Добро утро, общество!')
                    ->always(function () use ($currentChannelIndex) {
                        $currentChannelIndex++;
                        if (!isset($this->channels[$currentChannelIndex])) {
                            // TODO: monolog
                            exit(0);
                        }

                        $this->sendMessage($currentChannelIndex);
                    });
            } catch (NoPermissionsException $e) {
                // todo: monolog
            }
        } else {
            // todo: monolog
        }
    }
}
