<?php

namespace Yumerov\MaxiBot\Applications;

use Discord\Discord;
use Discord\WebSockets\Intents;
use Yumerov\MaxiBot\DiscordClient;
use Yumerov\MaxiBot\EnvLoader;
use Yumerov\MaxiBot\Exception;

abstract class BaseApplication
{

    protected string $discordToken;
    protected DiscordClient $client;
    /**
     * @var callable
     */
    protected $onReadyAction;

    public function __construct(protected readonly string $rootDir)
    {
    }

    public function setDiscordToken(string $token): static
    {
        $this->discordToken = $token;

        return $this;
    }

    public function initEnv(): static
    {
        (new EnvLoader($this->rootDir))->load();

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function initClient(): static
    {
        $this->setOnReadyAction();

        try {
            $this->client = new DiscordClient(
                new Discord([
                    'token' => $this->discordToken,
                    'intents' => Intents::getDefaultIntents()
                ]),
                $this->onReadyAction
            );
        } catch (\Exception $ex) {
            throw new Exception(message: 'Failed to init Discord client', previous: $ex);
        }

        return $this;
    }

    abstract protected function setOnReadyAction(): void;

    public function run(): void
    {
        $this->client->run();
    }
}
