<?php

namespace Actions;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Actions\OnMessageAction;
use PHPUnit\Framework\TestCase;
use Yumerov\MaxiBot\Pipeline\StepFactoryInterface;
use Yumerov\MaxiBot\Pipeline\Steps\StepInterface;

class OnMessageActionTest extends TestCase
{

    private LoggerInterface|MockObject $logger;
    private StepFactoryInterface|MockObject $factory;
    private Message|MockObject $message;
    private Discord|MockObject $discord;
    private $action;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->factory = $this->createMock(StepFactoryInterface::class);
        $this->message = $this->createMock(Message::class);
        $this->discord = $this->createMock(Discord::class);

        $this->action = new class($this->logger, $this->factory) extends OnMessageAction {
            public function setSteps(array $steps): void
            {
                $this->steps = $steps;
            }
        };
    }

    public function test_empty_array_list(): void
    {
        // Arrange & Assert
        $this->action->setSteps([]);
        $this->factory
            ->expects($this->never())
            ->method('create');
        $this->logger
            ->expects($this->never())
            ->method('debug');

        // Act
        call_user_func($this->action, $this->message, $this->discord);
    }

    public function test_return_null(): void
    {
        // Arrange & Assert
        $this->expectException(\Yumerov\MaxiBot\Exceptions\Exception::class);

        $class = 'Fake';
        $this->action->setSteps([$class]);
        $this->factory
            ->expects($this->once())
            ->method('create')
            ->with($class, $this->message, $this->discord)
            ->willReturn(null);
        $this->logger
            ->expects($this->never())
            ->method('debug');

        // Act
        call_user_func($this->action, $this->message, $this->discord);
    }

    /**
     * @throws Exception
     */
    public function test_stops_true(): void
    {
        // Arrange & Assert
        $class = 'Fake';
        $step = $this->createMock(StepInterface::class);
        $step
            ->expects($this->once())
            ->method('stops')
            ->willReturn(true);
        $step
            ->expects($this->never())
            ->method('execute');
        $this->action->setSteps([$class]);
        $this->factory
            ->expects($this->once())
            ->method('create')
            ->with($class, $this->message, $this->discord)
            ->willReturn($step);

        // Act
        call_user_func($this->action, $this->message, $this->discord);
    }

    /**
     * @throws Exception
     */
    public function test_execute(): void
    {
        // Arrange & Assert
        $class = 'Fake';
        $step = $this->createMock(StepInterface::class);
        $step
            ->expects($this->once())
            ->method('stops')
            ->willReturn(false);
        $step
            ->expects($this->once())
            ->method('execute');
        $this->action->setSteps([$class]);
        $this->factory
            ->expects($this->once())
            ->method('create')
            ->with($class, $this->message, $this->discord)
            ->willReturn($step);

        // Act
        call_user_func($this->action, $this->message, $this->discord);
    }
}
