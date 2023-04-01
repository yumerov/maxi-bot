<?php

namespace Yumerov\MaxiBot\Firewalls;

use Discord\Discord;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Mocks\Message;
use Yumerov\MaxiBot\Mocks\Traits\EnvTrait;
use Yumerov\MaxiBot\Mocks\User;

class MaintainerOnlyModeTest extends TestCase
{

    use EnvTrait;

    private const MAINTAINER = '1';

    private Message $message;
    private LoggerInterface|InvocationMocker $logger;
    private Discord|InvocationMocker $discord;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->message = new Message();
        $this->discord  = $this->createMock(Discord::class);
        $this->logger = $this->createMock(LoggerInterface::class);

    }

    public function test_null_author(): void
    {
        $this->assertTrue($this->initFirewall('true')->allow());
    }

    public function test_maintainerOnlyMode_not_true(): void
    {
        $this->message->author = new User('0');
        $this->assertTrue($this->initFirewall('FALSE')->allow());
    }

    public function test_author_is_not_maintainer(): void
    {
        // Arrange
        $this->message->author = new User('0');
        $this->logger
            ->expects($this->once())
            ->method('warning');

        // Act && Assert
        $this->assertFalse($this->initFirewall('true')->allow());
        $this->assertEquals(
            'Maintainer only mode is ON. Please z tip and DM <@' . self::MAINTAINER . '>',
            $this->message->replyContent
        );
    }

    public function test_author_is_maintainer(): void
    {
        // Arrange
        $this->message->author = new User(self::MAINTAINER);

        // Act && Assert
        $this->assertTrue($this->initFirewall('true')->allow());
    }

    private function initFirewall(string $maintainerOnlyMode): MaintainerOnlyMode
    {
        return new MaintainerOnlyMode(
            $this->discord,
            $this->message,
            $this->logger,
            $this->createEnvDTO(maintainerOnlyMode: $maintainerOnlyMode, maintainer: self::MAINTAINER)
        );
    }
}
