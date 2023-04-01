<?php

namespace Yumerov\MaxiBot\Discord;

use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\Exceptions\InviteInvalidException;
use Discord\WebSockets\Intents;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Exceptions\DiscordClientInitException;

class ClientFactoryTest extends TestCase
{
    private const TOKEN = "0xtoken";

    /**
     * @throws DiscordClientInitException
     * @throws Exception
     */
    public function test_create_fail_rethrow(): void
    {
        // Assert
        $this->expectException(DiscordClientInitException::class);

        // Arrange
        $logger = $this->createMock(LoggerInterface::class);
        $action = function () {

        };
        $instance = new class extends ClientFactory {
             public function getDiscord(string $token, LoggerInterface $logger): Discord
            {
                throw new IntentException();
            }
        };

        // Act
        $instance->create(self::TOKEN, $logger, $action);
    }

    public function test_create_fail_throw(): void
    {
        // Assert
        $this->expectException(InviteInvalidException::class);

        // Arrange
        $logger = $this->createMock(LoggerInterface::class);
        $action = function () {

        };
        $instance = new class extends ClientFactory {
             public function getDiscord(string $token, LoggerInterface $logger): Discord
            {
                throw new InviteInvalidException();
            }
        };

        // Act
        $instance->create(self::TOKEN, $logger, $action);
    }

    /**
     * @throws Exception
     * @throws DiscordClientInitException
     */
    public function test_create_success(): void
    {
        // Arrange
        $logger = $this->createMock(LoggerInterface::class);
        $action = function () {

        };
        $instance = new class extends ClientFactory {
             protected function getDiscord(string $token, LoggerInterface $logger): Discord
            {
                return new class extends Discord {
                    public function __construct()
                    {
                    }
                };
            }
        };

        // Act
        $client = $instance->create(self::TOKEN, $logger, $action);

        // Assert
        $this->assertInstanceOf(DiscordClient::class, $client);
    }
}
