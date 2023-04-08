<?php

namespace Yumerov\MaxiBot\Applications;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Discord\DiscordClient;
use Yumerov\MaxiBot\Discord\DiscordInterface;
use Yumerov\MaxiBot\DTO\EnvDTO;

abstract class BaseApplication
{

    protected DiscordInterface $client;
    /** @var callable */
    protected $onReadyAction;
    protected LoggerInterface $logger;
    protected EnvDTO $env;

    public function __construct(protected readonly ContainerInterface $container)
    {
    }

    public function initClient(): static
    {
        $this->setOnReadyAction();

        $this->client = $this->container->get('Discord');
        $this->client->setOnReadyAction($this->onReadyAction);

        return $this;
    }

    abstract protected function setOnReadyAction(): void;

    public function run(): void
    {
        $this->client->run();
    }
}
