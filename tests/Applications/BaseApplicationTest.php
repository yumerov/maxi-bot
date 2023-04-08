<?php

namespace Yumerov\MaxiBot\Applications;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Yumerov\MaxiBot\Discord\DiscordInterface;

class BaseApplicationTest extends TestCase
{

    private $onReadyAction;
    private ContainerInterface|MockObject $container;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $this->onReadyAction = new class {
            public function __invoke(): void
            {
            }
        };
        $this->container = $this->createMock(ContainerInterface::class);
    }

    /**
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function test_initClient(): void
    {
        // Arrange
        $app = $this->initApplication();
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with('Discord')
            ->willReturn($this->createMock(DiscordInterface::class));

        // Act
        $instance = $app->initClient();

        // Assert
        $this->assertInstanceOf(BaseApplication::class, $instance);
        $this->assertNotNull($instance->getClient());
    }

    private function initApplication()
    {
        return new class($this->container, $this->onReadyAction) extends BaseApplication
        {
            public function __construct(
                protected readonly ContainerInterface $container,
                private $action
            ) {
                $this->onReadyAction = $this->action;
            }

            protected function setOnReadyAction(): void
            {
                $this->onReadyAction = $this->action;
            }

            public function getClient(): DiscordInterface
            {
                return $this->client;
            }
        };
    }
}
