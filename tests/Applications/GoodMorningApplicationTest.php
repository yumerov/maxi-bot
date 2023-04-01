<?php

namespace Yumerov\MaxiBot\Applications;

use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Actions\GoodMorningAction;
use Yumerov\MaxiBot\DTO\EnvDTO;
use Yumerov\MaxiBot\Exceptions\MalformedGoodMorningChannelListException;
use Yumerov\MaxiBot\Mocks\Traits\EnvDTOTrait;

class GoodMorningApplicationTest extends TestCase
{

    use EnvDTOTrait;

    public function test_setChannels_malformed(): void
    {
        // Pre assert
        $this->expectException(MalformedGoodMorningChannelListException::class);
        $this->expectExceptionMessage('Malformed good morning channel list');

        // Act
        $instance = $this->initApplication('[')->setChannels();
    }

    public function test_setChannels_successfully(): void
    {
        // Arrange
        $channels = ["0xchannel"];

        // Act
        $instance = $this->initApplication("[\"$channels[0]\"]")
            ->setChannels();

        // Assert
        $this->assertInstanceOf(GoodMorningApplication::class, $instance);
        $this->assertEquals($channels, $instance->getChannels());
    }

    /**
     * @throws Exception
     */
    public function test_setOnReadyAction(): void
    {
        // Arrange
        $channels = ["0xchannel"];
        $instance = $this->initApplication("[\"$channels[0]\"]");
        $instance->setChannels();
        $instance->setLogger($this->createMock(LoggerInterface::class));

        // Act
        $instance->setOnReadyAction();

        // Assert
        $this->assertInstanceOf(GoodMorningAction::class, $instance->getOnReadyAction());
    }

    /**
     * @throws Exception
     */
    private function initApplication(string $channels = '["0"]')
    {
        return new class($this->createEnvDTO($channels)) extends GoodMorningApplication {
            public function __construct(EnvDTO $env)
            {
                $this->env = $env;
            }

            public function getChannels(): array
            {
                return $this->channels;
            }
            public function getOnReadyAction(): callable
            {
                return  $this->onReadyAction;
            }
            public function setOnReadyAction(): void
            {
                parent::setOnReadyAction();
            }
            public function setLogger(LoggerInterface $logger)
            {
                $this->logger = $logger;
            }
        };
    }
}
