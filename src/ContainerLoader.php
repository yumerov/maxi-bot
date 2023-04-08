<?php

namespace Yumerov\MaxiBot;

use Symfony\Component\Config\FileLocator;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContainerLoader
{
    public function __construct(
        private readonly string $rootDir,
        private readonly EnvLoader $envLoader,
        private readonly ContainerBuilder $container
    ) {
    }

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
}
