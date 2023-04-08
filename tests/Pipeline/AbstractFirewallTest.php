<?php

namespace Yumerov\MaxiBot\Pipeline;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class AbstractFirewallTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function test(): void
    {
        // Arrange
        $instance = new class(
            $this->createMock(LoggerInterface::class)
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
