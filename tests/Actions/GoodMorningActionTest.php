<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Http\Exceptions\NoPermissionsException;
use Discord\Parts\Channel\Message;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use React\Promise\ExtendedPromiseInterface;
use Yumerov\MaxiBot\Exceptions\ExitException;
use Yumerov\MaxiBot\Mocks\Channel;
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
            ->expects($this->once())
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

    public function test_no_permission_exception(): void
    {
        // Arrange
        $exception = new NoPermissionsException('No permission');
        $discord = new class($exception) extends Discord {
            public function __construct(private readonly NoPermissionsException $exception)
            {
            }

            public function getChannel($channelId): ?Channel
            {
                return new class($this->exception) extends Channel {

                    public function __construct(private readonly NoPermissionsException $exception)
                    {
                    }

                    public function sendMessage($message, bool $tts = false, $embed = null, $allowed_mentions = null, ?Message $replyTo = null): ExtendedPromiseInterface
                    {
                        throw $this->exception;
                    }
                };
            }
        };
        $channels = ['1'];
        $this->logger
            ->expects($this->once())
            ->method('error')
            ->with($exception->getMessage());

        // Act
        call_user_func(
            new GoodMorningAction($channels, $this->logger),
            $discord
        );
    }
}
