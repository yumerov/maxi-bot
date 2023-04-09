<?php

namespace Pipeline;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Pipeline\StepFactory;
use PHPUnit\Framework\TestCase;
use Yumerov\MaxiBot\Pipeline\Steps\StepInterface;

class StepFactoryTest extends TestCase
{

    private LoggerInterface|MockObject $logger;
    private ContainerInterface|MockObject $container;
    private Message|MockObject $message;
    private Discord|MockObject $discord;
    private StepFactory $factory;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->container = $this->createMock(ContainerInterface::class);
        $this->message = $this->createMock(Message::class);
        $this->discord = $this->createMock(Discord::class);

        $this->factory = new StepFactory($this->logger, $this->container);
    }

    public function test_create_not_implementing(): void
    {
        // Arrange
        $class = new class {

        };

        // Assert
        $this->logger
            ->expects($this->once())
            ->method('warning');

        $this->container
            ->expects($this->never())
            ->method('get');

        // Act
        $this->factory->create(get_class($class), $this->message, $this->discord);
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws Exception
     * @throws \ReflectionException
     * @throws ContainerExceptionInterface
     */
    public function test_create_successfully(): void
    {
        // Arrange
        $step = $this->createMock(StepInterface::class);
        $step->expects($this->once())->method('setDiscord')->willReturnSelf();
        $step->expects($this->once())->method('setMessage')->willReturnSelf();

        // Assert
        $this->logger
            ->expects($this->never())
            ->method('warning');

        $this->container
            ->expects($this->once())
            ->method('get')
            ->with((new \ReflectionClass($step))->getShortName())
            ->willReturn($step);

        // Act
        $this->assertSame(
            $step,
            $this->factory->create(get_class($step), $this->message, $this->discord)
        );
    }
}
