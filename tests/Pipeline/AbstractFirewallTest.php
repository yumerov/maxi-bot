<?php

namespace Yumerov\MaxiBot\Pipeline;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Mocks\Traits\EnvTrait;

class AbstractFirewallTest extends TestCase
{

    use EnvTrait;

    /**
     * @throws Exception
     */
    public function test(): void
    {
        // Arrange
        $instance = new class(
            $this->createMock(Discord::class),
            $this->createMock(Message::class),
            $this->createMock(LoggerInterface::class),
            $this->createEnvDTO()
        ) extends AbstractFirewall {

            public function allow(): bool
            {
                return true;
            }
        };

        // Act
        $instance->execute();

        // Assert
        $this->assertEquals(!$instance->allow(), $instance->stops());
    }
}
