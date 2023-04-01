<?php

namespace Yumerov\MaxiBot\Applications;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Mocks\Traits\EnvTrait;

class BaseApplicationTest extends TestCase
{

    use EnvTrait;

    public function test_initEnv(): void
    {
        // Arrange
        $this->unsetEnv($this->envData);
        $app = $this->initApplication(__DIR__ . '/../resources/valid');

        // Act
        $result = $app->initEnv();

        // Assert
        $this->assertInstanceOf(BaseApplication::class, $result);
        foreach ($this->envData as $key => $value)
        {
            $this->assertEquals($value, $_ENV[$key]);
        }
    }

    public function test_initLogger(): void
    {
        // Arrange
        $app = $this->initApplication(__DIR__ . '/../resources/valid');

        // Act
        $instance = $app->initLogger();

        // Assert
        $this->assertInstanceOf(BaseApplication::class, $instance);
        $this->assertNotNull($instance->getLogger());
    }

    private function initApplication(string $roodDir)
    {
        return new class($roodDir) extends BaseApplication
        {

            protected function setOnReadyAction(): void
            {
            }

            public function getLogger(): LoggerInterface
            {
                return $this->logger;
            }
        };
    }
}
