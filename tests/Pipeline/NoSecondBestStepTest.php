<?php

namespace Yumerov\MaxiBot\Pipeline;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class NoSecondBestStepTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function test(): void
    {
        // Arrange
        $message = $this->createMock(Message::class);
        $discord = $this->createMock(Discord::class);
        $logger = $this->createMock(LoggerInterface::class);

        $message
            ->expects($this->once())
            ->method('reply')
            ->with('There is no second best!');

        $step = new NoSecondBestStep($logger);
        $step->setDiscord($discord);
        $step->setMessage($message);

        // Act
        $step->execute();

        // Assert
        $this->assertFalse($step->stops());
    }
}
