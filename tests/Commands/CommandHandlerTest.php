<?php

namespace Commands;

use Discord\Discord;
use Discord\Parts\Interactions\Command\Command;
use Discord\Parts\Interactions\Interaction;
use Discord\Parts\OAuth\Application;
use Discord\Repository\Interaction\GlobalCommandRepository;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use ReflectionClassConstant;
use ReflectionProperty;
use Yumerov\MaxiBot\Commands\CommandFactoryInterface;
use Yumerov\MaxiBot\Commands\CommandHandler;
use PHPUnit\Framework\TestCase;
use Yumerov\MaxiBot\Commands\CommandInterface;
use Yumerov\MaxiBot\Exceptions\Exception;

class CommandHandlerTest extends TestCase
{

    private CommandFactoryInterface|MockObject $factory;
    private Discord|MockObject $discord;
    private CommandHandler $handler;
    private ReflectionProperty $commands;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     * @throws \ReflectionException
     */
    protected function setUp(): void
    {
        $this->factory = $this->createMock(CommandFactoryInterface::class);
        $this->discord = $this->createMock(Discord::class);
        $this->handler = new CommandHandler($this->factory);
        $this->commands = (new ReflectionClass($this->handler))->getProperty('commands');
    }

    public function test_iterate_null(): void
    {
        // Assert
        $this->expectException(Exception::class);

        // Arrange
        $class = new class { };
        $this->commands->setValue($this->handler, [get_class($class)]);
        $this->factory
            ->expects($this->once())
            ->method('create')
            ->willReturn(null);

        // Act
        $this->handler->iterate($this->discord);
    }

    /**
     * @throws Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function test_iterate(): void
    {
        // Arrange && Assert
        $class = new class implements CommandInterface {
            public function getName(): string
            {
                return 'test';
            }

            public function getDescription(): string
            {
                return 'Test Description';
            }

            public function execute(Interaction $interaction): void
            {
            }
        };
        $this->commands->setValue($this->handler, [get_class($class)]);
        $this->factory
            ->expects($this->once())
            ->method('create')
            ->willReturn($class);

        $commandRepository = $this->createMock(GlobalCommandRepository::class);
        $commandRepository->expects($this->once())
            ->method('save')
            ->with(new Command(
                $this->discord, [
                    'name' => $class->getName(),
                    'description' => $class->getDescription()
                ]
            ));
        $application = $this->createMock(Application::class);
        $application
            ->expects($this->once())
            ->method('__get')
            ->with('commands')
            ->willReturn($commandRepository);
        $this->discord
            ->expects($this->once())
            ->method('__get')
            ->with('application')
            ->willReturn($application);
        $this->discord
            ->expects($this->once())
            ->method('listenCommand')
            ->with($class->getName(), [$class, 'execute']);

        // Act
        $this->handler->iterate($this->discord);
    }
}
