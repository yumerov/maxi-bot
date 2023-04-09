<?php


use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Yumerov\MaxiBot\ContainerLoader;
use PHPUnit\Framework\TestCase;
use Yumerov\MaxiBot\EnvLoader;
use Yumerov\MaxiBot\Exceptions\Exception as BotException;

class ContainerLoaderTest extends TestCase
{
    private const ROOT_DIR = __DIR__ . '/resources';
    private EnvLoader|MockObject $envLoader;
    private ContainerBuilder|MockObject $container;

    /**
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    protected function setUp(): void
    {
        $this->envLoader = $this->createMock(EnvLoader::class);
        $this->container = $this->createMock(ContainerBuilder::class);

        $reflectionClass = new ReflectionClass(ContainerLoader::class);
        $reflectionProperty = $reflectionClass->getProperty('instance');
        $reflectionProperty->setValue(null);
    }

    public function test_getInstance_null(): void
    {
        // Assert
        $this->expectException(BotException::class);

        // Act
        ContainerLoader::getInstance();
    }

    /**
     * @throws BotException
     */
    public function test_getInstance_not_null(): void
    {
        // Arrange
        $firstInstance = $this->initContainerLoader();

        // Act
        $secondInstance = ContainerLoader::getInstance();

        // Assert
        $this->assertSame($firstInstance, $secondInstance);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function test_load(): void
    {
        // Arrange
        $loader = $this->initContainerLoader();
        $this->container
            ->expects($this->once())
            ->method('setParameter')
            ->with('kernel.root_dir', self::ROOT_DIR);
        $this->container
            ->expects($this->once())
            ->method('set')
            ->with('Container', $this->container);
        $this->envLoader
            ->expects($this->once())
            ->method('load');
        $this->container
            ->expects($this->once())
            ->method('compile')
            ->with(true);

        // Act
        $loader->load();

        // Assert
    }

    /**
     * @throws Exception
     */
    public function test_get(): void
    {
        // Arrange
        $id = 'service';
        $service = new class { };
        $instance = $this->initContainerLoader();
        $this->container
            ->expects($this->once())
            ->method('get')
            ->with($id)
            ->willReturn($service);

        // Act
        $returnedService = $instance->get($id);

        // Assert
        $this->assertSame($service, $returnedService);
    }

    public function test_has(): void
    {
        // Arrange
        $id = 'service';
        $instance = $this->initContainerLoader();
        $this->container
            ->expects($this->once())
            ->method('has')
            ->with($id)
            ->willReturn(false);

        // Act && Assert
        $this->assertFalse($instance->has($id));
    }

    private function initContainerLoader(): ContainerLoader
    {
        return new ContainerLoader(self::ROOT_DIR, $this->envLoader, $this->container);
    }
}
