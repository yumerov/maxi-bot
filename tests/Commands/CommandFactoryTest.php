<?php

namespace Commands;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Commands\CommandFactory;
use PHPUnit\Framework\TestCase;
use Yumerov\MaxiBot\Commands\CommandFactoryInterface;
use Yumerov\MaxiBot\Commands\CommandInterface;
use Yumerov\MaxiBot\Pipeline\Steps\StepInterface;

class CommandFactoryTest extends TestCase
{

    private LoggerInterface|MockObject $logger;
    private ContainerInterface|MockObject $container;
    private CommandFactory $factory;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->container = $this->createMock(ContainerInterface::class);

        $this->factory = new CommandFactory($this->logger, $this->container);
    }

    /**
     * @throws \ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
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
        $this->factory->create(get_class($class));
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws \ReflectionException
     */
    public function test_create_successfully(): void
    {
        // Arrange
        $command = $this->createMock(CommandInterface::class);

        // Assert
        $this->logger
            ->expects($this->never())
            ->method('warning');

        $this->container
            ->expects($this->once())
            ->method('get')
            ->with((new \ReflectionClass($command))->getShortName())
            ->willReturn($command);

        // Act
        $this->assertSame(
            $command,
            $this->factory->create(get_class($command))
        );
    }
}
