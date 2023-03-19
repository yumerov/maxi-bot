<?php

namespace Yumerov\MaxiBot;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;
use Discord\WebSockets\Intents;
use Dotenv\Dotenv;

/**
 * Represents the application and container class
 */
final class Application
{

    private readonly string $discordToken;

    public function __construct(private readonly string $rootDir)
    {
    }

    public function setDiscordToken(string $token): self
    {
        $this->discordToken = $token;

        return $this;
    }

    public function initEnv(): self
    {
        $dotenv = Dotenv::createImmutable($this->rootDir);
        $dotenv->load();
        $dotenv->required('DISCORD_TOKEN');

        return $this;
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
                'intents' => Intents::getDefaultIntents()
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

                $mentions = $message->mentions;

                if ($mentions->count() !== 1) {
                    // todo: replace with monolog
                    return;
                }

                if ($mentions->first()->id !== $discord->user->id) {
                    // todo: replace with monolog
                    return;
                }

                echo "message here!!!";
                $message->reply('There is no second best!');
            });
        });

        $discord->run();
    }
}
