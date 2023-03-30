<?php

namespace Yumerov\MaxiBot\Applications;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Actions\OnReadyAction;

class MainApplicationTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function test_setOnReadyAction(): void
    {
        // Arrange
        $application = new class('.') extends MainApplication {
            public function setLogger(LoggerInterface $logger)
            {
                $this->logger = $logger;
            }
            public function getOnReadyAction(): callable
            {
                return  $this->onReadyAction;
            }
            public function setOnReadyAction(): void
            {
                parent::setOnReadyAction();
            }
        };
        $application->setLogger($this->createMock(LoggerInterface::class));
        $application->setEnv([
            'DISCORD_TOKEN' => '0xtoken',
            'GOOD_MORNING_CHANNELS' => '["0"]',
            'MAINTAINER' => '1',
            'ALLOWED_SERVERS' => '["2"]',
            'MAINTAINER_ONLY_MODE' => 'true',
        ]);

        // Act
        $application->setOnReadyAction();

        // Assert
        $action = $application->getOnReadyAction();
        $this->assertTrue(is_callable($action));
        $this->assertEquals(OnReadyAction::class, get_class($action));
    }

}
