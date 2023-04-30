<?php

namespace Yumerov\MaxiBot\Applications;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Yumerov\MaxiBot\Actions\GoodMorningAction;

class GoodMorningApplicationTest extends TestCase
{

    private $onReadyAction;
    private ContainerInterface|MockObject $container;

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $this->onReadyAction = new class {
            public function __invoke(): void
            {
            }
        };
        $this->container = $this->createMock(ContainerInterface::class);
    }

    /**
     * @throws Exception
     */
    public function test_setOnReadyAction(): void
    {
        // Arrange
        $instance = $this->initApplication();
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with('GoodMorningAction')
            ->willReturn($this->createMock(GoodMorningAction::class));

        // Act
        $instance->setOnReadyAction();

        // Assert
        $this->assertInstanceOf(GoodMorningAction::class, $instance->getOnReadyAction());
    }


    private function initApplication()
    {
        return new class($this->container) extends GoodMorningApplication {

            public function getOnReadyAction(): callable
            {
                return  $this->onReadyAction;
            }

            public function setOnReadyAction(): void
            {
                parent::setOnReadyAction();
            }
        };
    }
}
