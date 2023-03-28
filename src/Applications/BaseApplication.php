<?php

namespace Yumerov\MaxiBot\Applications;

use Discord\Discord;
use Discord\WebSockets\Intents;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\DiscordClient;
use Yumerov\MaxiBot\EnvLoader;
use Yumerov\MaxiBot\Exceptions\Exception;

abstract class BaseApplication
{

    protected DiscordClient $client;
    /**
     * @var callable
     */
    protected $onReadyAction;
    protected LoggerInterface $logger;
    protected array $env;

    public function __construct(protected readonly string $rootDir)
    {
    }

    public function setEnv(array $env): static
    {
        $this->env = $env;

        return $this;
    }

    public function initEnv(): static
    {
        (new EnvLoader($this->rootDir))->load();

        return $this;
    }

    public function initLogger(): static
    {
        $this->logger = new Logger('main');
        $this->logger->pushHandler(new StreamHandler($this->rootDir. '/var/logs/log.log'));

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
                    'token' => $this->env['DISCORD_TOKEN'],
                    'intents' => Intents::getDefaultIntents(),
                    'logger' => $this->logger
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
