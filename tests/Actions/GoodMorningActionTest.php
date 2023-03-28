<?php

namespace Yumerov\MaxiBot\Actions;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Exceptions\ExitException;
use Yumerov\MaxiBot\Mocks\Discord;

class GoodMorningActionTest extends TestCase
{

    private LoggerInterface|MockObject $logger;
    private Discord $discord;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->discord = new Discord();
    }

    /**
     * @throws Exception
     */
    public function test_empty_channel_list(): void
    {
        // Assert
        $this->expectException(ExitException::class);

        // Act
        call_user_func(
            new GoodMorningAction([], $this->logger),
            $this->discord
        );
    }

    public function test_null_channel(): void
    {
        // Arrange
        $channels = ['0'];
        $this->logger
            ->expects($this->exactly(2))
            ->method('debug');

        // Act
        call_user_func(
            new GoodMorningAction($channels, $this->logger),
            $this->discord
        );
    }

    public function test_channels(): void
    {
        // Arrange
        $this->expectException(ExitException::class);
        $channels = ['1', '2', '3'];
        $this->logger
            ->expects($this->exactly(2))
            ->method('debug');

        // Act
        call_user_func(
            new GoodMorningAction($channels, $this->logger),
            $this->discord
        );

        // Assert
        foreach ($this->discord->channels as $channel) {
            $this->assertEquals('Добро утро, общество!', $channel->message);
        }
    }
}
