<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\WebSockets\Event;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class OnReadyActionTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function test_invoke(): void
    {
        // Arrange && Assert
        $onMessage = $this->createMock(OnMessageAction::class);
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects($this->once())
            ->method('debug');
        $discord = $this->createMock(Discord::class);
        $discord
            ->expects($this->once())
            ->method('on')
            ->with(Event::MESSAGE_CREATE, $onMessage);

        // Act
        call_user_func(new OnReadyAction($onMessage, $logger), $discord);
    }
}
