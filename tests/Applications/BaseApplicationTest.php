<?php

namespace Yumerov\MaxiBot\Applications;

use http\Exception\BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Discord\ClientFactory;
use Yumerov\MaxiBot\Discord\DiscordClient;
use Yumerov\MaxiBot\DTO\EnvDTO;
use Yumerov\MaxiBot\Exceptions\Exception;
use Yumerov\MaxiBot\Mocks\Traits\EnvTrait;

class BaseApplicationTest extends TestCase
{

    use EnvTrait;

    private EnvDTO $env;
    private $onReadyAction;

    protected function setUp(): void
    {
        $this->env = $this->createEnvDTO();
        $this->onReadyAction = new class {
            public function __invoke(): void
            {
            }
        };
    }

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

    public function test_initClientFactory(): void
    {
        // Arrange
        $app = $this->initApplication(__DIR__ . '/../resources/valid');

        // Act
        $instance = $app->initClientFactory();

        // Assert
        $this->assertInstanceOf(BaseApplication::class, $instance);
        $this->assertNotNull($instance->getClientFactory());
    }

    /**
     * @throws Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function test_initClient(): void
    {
        // Arrange
        $app = $this->initApplication(__DIR__ . '/../resources/valid');
        $app->setEnv($this->envData);
        $logger = $this->createMock(LoggerInterface::class);
        $app->setLogger($logger);
        $factory = $this->createMock(ClientFactory::class);
        $app->setClientFactory($factory);
        $factory->expects($this->once())
            ->method('create')
            ->with(
                $this->env->discordToken,
                $logger,
                $this->onReadyAction
            );

        // Act
        $instance = $app->initClient();

        // Assert
        $this->assertInstanceOf(BaseApplication::class, $instance);
        $this->assertNotNull($instance->getClient());
    }

    private function initApplication(string $roodDir)
    {
        return new class($roodDir, $this->onReadyAction) extends BaseApplication
        {
            public function __construct(protected readonly string $rootDir, private $action)
            {
            }

            protected function setOnReadyAction(): void
            {
                $this->onReadyAction = $this->action;
            }

            public function setLogger(LoggerInterface $logger): void
            {
                $this->logger = $logger;
            }

            public function getLogger(): LoggerInterface
            {
                return $this->logger;
            }

            public function setClientFactory(ClientFactory $factory)
            {
                $this->clientFactory = $factory;
            }

            public function getClientFactory(): ClientFactory
            {
                return $this->clientFactory;
            }

            public function getClient(): DiscordClient
            {
                return $this->client;
            }
        };
    }
}
