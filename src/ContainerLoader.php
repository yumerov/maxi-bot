<?php

namespace Yumerov\MaxiBot;

use Symfony\Component\Config\FileLocator;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Yumerov\MaxiBot\Exceptions\Exception;

class ContainerLoader implements ContainerInterface
{
    private static ?self $instance;

    public function __construct(
        private readonly string $rootDir,
        private readonly EnvLoader $envLoader,
        private readonly ContainerBuilder $container
    ) {
        self::$instance = $this;
    }

    /**
     * @return ContainerLoader|null
     * @throws Exception
     */
    public static function getInstance(): ?ContainerLoader
    {
        if (self::$instance === null) {
            throw new Exception('Container is not loaded');
        }

        return self::$instance;
    }

    /**
     * @throws \Exception
     */
    public function load(): ContainerInterface
    {
        $this->container->setParameter('kernel.root_dir', $this->rootDir);
        $this->container->set('Container', $this->container);
        $fileLocator = new FileLocator($this->rootDir . '/config/');
        $loader = new YamlFileLoader($this->container, $fileLocator);
        $this->envLoader->load();
        $loader->load('parameters.yaml');
        $loader->load('services.yaml');
        $this->container->compile(true);

        return $this->container;
    }

    /**
     * @throws \Exception
     */
    public function get(string $id)
    {
        return $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }
}
