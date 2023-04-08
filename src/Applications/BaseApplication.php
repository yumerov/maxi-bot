<?php

namespace Yumerov\MaxiBot\Applications;

use Psr\Container\ContainerInterface;
use Yumerov\MaxiBot\Discord\DiscordInterface;

abstract class BaseApplication
{

    protected DiscordInterface $client;
    /** @var callable */
    protected $onReadyAction;

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
