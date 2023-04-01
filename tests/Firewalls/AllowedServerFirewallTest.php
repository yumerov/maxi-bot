<?php

namespace Yumerov\MaxiBot\Firewalls;

use Discord\Discord;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\DTO\EnvDTO;
use Yumerov\MaxiBot\Mocks\Message;
use Yumerov\MaxiBot\Mocks\Thread;

class AllowedServerFirewallTest extends TestCase
{

    private Message $message;
    private Discord $discord;
    private string $maintainer = '0x123';

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->message = new Message();
        $this->discord = $this->createMock(Discord::class);
    }

    /**
     * @throws Exception
     */
    public function test_malformed_data(): void
    {
        $this->assertFalse($this->initFirewall('[')->allow());
    }

    /**
     * @throws Exception
     */
    public function test_empty_allow_list(): void
    {
        $this->assertFalse($this->initFirewall('[]')->allow());
    }

    /**
     * @throws Exception
     */
    public function test_not_in_allowed_list(): void
    {
        // Arrange
        $this->message->channel = new Thread('1');

        // Act
        $isAllowed = $this->initFirewall('["0"]')->allow();

        // Assert
        $this->assertFalse($isAllowed);
        $this->assertEquals(
            "This server is not in allowed list. Please z tip and DM <@{$this->maintainer}>",
            $this->message->replyContent
        );
    }

    /**
     * @throws Exception
     */
    public function test_in_allowed_list(): void
    {
        // Arrange
        $this->message->channel = new Thread('0');

        // Act && Assert
        $this->assertTrue($this->initFirewall('["0"]')->allow());
    }

    /**
     * @throws Exception
     */
    private function initFirewall(string $allowedServers): AllowedServerFirewall
    {
        return new AllowedServerFirewall(
            $this->discord,
            $this->message,
            $this->createMock(LoggerInterface::class),
            new EnvDTO([
                'DISCORD_TOKEN' => '0xtoken',
                'GOOD_MORNING_CHANNELS' => '["0"]',
                'ALLOWED_SERVERS' => $allowedServers,
                'MAINTAINER' => $this->maintainer,
                'MAINTAINER_ONLY_MODE' => 'false',
            ])
        );
    }
}
