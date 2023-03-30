<?php

namespace Yumerov\MaxiBot\Firewalls;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\DTO\EnvDTO;
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
            new EnvDTO([
                'DISCORD_TOKEN' => '0xtoken',
                'GOOD_MORNING_CHANNELS' => '["0"]',
                'MAINTAINER' => '1',
                'ALLOWED_SERVERS' => '["2"]',
                'MAINTAINER_ONLY_MODE' => 'true',
            ])
        );
    }

    public function test_null_author(): void
    {
        // Act && Assert
        $this->assertFalse($this->firewall->allow());
    }

    public function test_author_is_this(): void
    {
        // Arrange
        $this->message->author = new User('0');
        $this->discord->user = new User('0');

        // Act && Assert
        $this->assertFalse($this->firewall->allow());
    }

    public function test_zero_mentions(): void
    {
        // Arrange
        $this->message->author = new User('0');
        $this->discord->user = new User('1');

        // Act && Assert
        $this->assertFalse($this->firewall->allow());
    }

    public function test_two_mentions(): void
    {
        // Arrange
        $this->message->author = new User('0');
        $this->message->mentions->push(new User('2'), new User('3'));
        $this->discord->user = new User('1');

        // Act && Assert
        $this->assertFalse($this->firewall->allow());
    }

    public function test_mention_is_not_the_bot(): void
    {
        // Arrange
        $this->message->author = new User('0');
        $this->message->mentions->push(new User('2'));
        $this->discord->user = new User('1');

        // Act && Assert
        $this->assertFalse($this->firewall->allow());
    }

    public function test_bot_mentions_itself(): void
    {
        // Arrange
        $bot = new User('1');
        $this->message->author = $bot;
        $this->message->mentions->push($bot);
        $this->discord->user = $bot;

        // Act && Assert
        $this->assertFalse($this->firewall->allow());
    }

    public function test_user_mentions_the_bot(): void
    {
        // Arrange
        $bot = new User('1');
        $this->message->author = new User('0');
        $this->message->mentions->push($bot);
        $this->discord->user = $bot;

        // Act && Assert
        $this->assertTrue($this->firewall->allow());
    }
}
