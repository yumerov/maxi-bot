<?php

namespace Yumerov\MaxiBot\Pipeline;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\DTO\EnvDTO;
use Yumerov\MaxiBot\Mocks\Traits\EnvTrait;

class NoSecondBestStepTest extends TestCase
{

    use EnvTrait;

    /**
     * @throws Exception
     */
    public function test(): void
    {
        // Arrange
        $discord = $this->createMock(Discord::class);
        $message = $this->createMock(Message::class);
        $logger = $this->createMock(LoggerInterface::class);
        $env = $this->createEnvDTO();

        $message
            ->expects($this->once())
            ->method('reply')
            ->with('There is no second best!');

        $step = new NoSecondBestStep(
            $discord,
            $message,
            $logger,
            $env
        );

        // Act
        $step->execute();

        // Assert
        $this->assertFalse($step->stops());
    }
}
