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

    private string $discordToken;
    private DiscordWrapper $discordWrapper;

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
     * @return $this
     * @throws Exception
     */
    public function initWrapper(): self
    {
        try {
            $this->discordWrapper = new DiscordWrapper(
                new Discord([
                    'token' => $this->discordToken,
                    'intents' => Intents::getDefaultIntents()
                ])
            );
        } catch (\Exception $ex) {
            throw new Exception(message: 'Failed to init Discord client', previous: $ex);
        }

        return $this;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $this->discordWrapper->run();
    }
}
