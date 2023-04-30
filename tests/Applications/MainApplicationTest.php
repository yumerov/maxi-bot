<?php

namespace Yumerov\MaxiBot\Applications;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
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
        $mockAction = $this->createMock(OnReadyAction::class);
        $container = $this->createMock(ContainerInterface::class);
        $container
            ->expects($this->once())
            ->method('get')
            ->with('OnReadyAction')
            ->willReturn($mockAction);
        $application = new class($container) extends MainApplication {
            public function getOnReadyAction(): callable
            {
                return  $this->onReadyAction;
            }
            public function setOnReadyAction(): void
            {
                parent::setOnReadyAction();
            }
        };

        // Act
        $application->setOnReadyAction();

        // Assert
        $action = $application->getOnReadyAction();
        $this->assertTrue(is_callable($action));
        $this->assertEquals(get_class($mockAction), get_class($action));
    }

}
