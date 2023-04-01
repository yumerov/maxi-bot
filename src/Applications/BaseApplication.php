<?php

namespace Yumerov\MaxiBot\Applications;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Discord\ClientFactory;
use Yumerov\MaxiBot\Discord\DiscordClient;
use Yumerov\MaxiBot\DTO\EnvDTO;
use Yumerov\MaxiBot\EnvLoader;
use Yumerov\MaxiBot\Exceptions\Exception;

abstract class BaseApplication
{

    protected DiscordClient $client;
    protected ClientFactory $clientFactory;
    /**
     * @var callable
     */
    protected $onReadyAction;
    protected LoggerInterface $logger;
    protected EnvDTO $env;

    public function __construct(protected readonly string $rootDir)
    {
    }

    public function setEnv(array $env): static
    {
        $this->env = new EnvDTO($env);

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
        $this->logger->pushHandler(new StreamHandler($this->rootDir . '/var/logs/log.log'));

        return $this;
    }

    public function initClientFactory(): static
    {
        $this->clientFactory = new ClientFactory();
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function initClient(): static
    {
        $this->setOnReadyAction();

        $this->client = $this->clientFactory->create(
            $this->env->discordToken,
            $this->logger,
            $this->onReadyAction
        );

        return $this;
    }

    /**
     * @throws Exception
     */
    public function init(): static
    {
        $this
            ->initLogger()
            ->initClientFactory()
            ->initClient();

        return $this;
    }

    abstract protected function setOnReadyAction(): void;

    public function run(): void
    {
        $this->client->run();
    }
}
