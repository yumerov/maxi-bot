<?php

namespace Yumerov\MaxiBot\Applications;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Yumerov\MaxiBot\Discord\DiscordInterface;
use Yumerov\MaxiBot\Exceptions\ExitException;

abstract class BaseApplication
{

    protected DiscordInterface $client;
    /** @var callable */
    protected $onReadyAction;

    public function __construct(protected readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
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
        try {
            $this->client->run();
        } catch (ExitException $exception) {
            $this->container->get('Logger')->debug($exception->getMessage());
            exit();
        }
    }
}
