<?php

namespace Yumerov\MaxiBot;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;

class Application
{
    private readonly string $discordToken;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $token = getenv('DISCORD_TOKEN');
        if ($token) {
            $this->discordToken = $token;
        } else {
            throw new Exception("Missing 'DISCORD_TOKEN' env variable");
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        try {
            $discord = new Discord([
                'token' => $this->discordToken,
                'intents' => 2048
            ]);
        } catch (\Exception $ex) {
            throw new Exception(message: 'Failed to init Discord client', previous: $ex);
        }

        $discord->on('ready', function (Discord $discord) {
            echo "Bot is ready!", PHP_EOL; // todo: replace with monolog

            $discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
                if ($message->author->bot) {
                    // todo: replace with monolog
                    return;
                }

                $message->reply('There is no second best!');
            });
        });

        $discord->run();
    }
}
