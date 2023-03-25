<?php

namespace Yumerov\MaxiBot\Firewalls;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Mocks\Discord;
use Yumerov\MaxiBot\Mocks\Message;
use Yumerov\MaxiBot\Mocks\User;

class NotMeFirewallTest extends TestCase
{

    private NotMeFirewall $firewall;
    private Discord $discord;
    private Message $message;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->discord = new Discord();
        $this->message = new Message();
        $this->firewall = new NotMeFirewall(
            $this->discord,
            $this->message,
            $this->createMock(LoggerInterface::class),
            []
        );
    }

    public function test_null_author(): void
    {
        // Act && Assert
        $this->assertTrue($this->firewall->allow());
    }

    public function test_author_is_this(): void
    {
        // Arrange
        $this->message->author = new User('0');
        $this->discord->user = new User('0');

        // Act && Assert
        $this->assertFalse($this->firewall->allow());
    }

    public function test_author_not_is_this(): void
    {
        // Arrange
        $this->message->author = new User('0');
        $this->discord->user = new User('1');

        // Act && Assert
        $this->assertTrue($this->firewall->allow());
    }
}
