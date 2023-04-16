<?php

namespace Yumerov\MaxiBot\Commands;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;

class CommandFactory implements CommandFactoryInterface
{

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ContainerInterface $container
    ) {
    }


    /**
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $class): ?CommandInterface
    {
        $reflectionClass = new ReflectionClass($class);

        if (! $reflectionClass->implementsInterface(CommandInterface::class)) {
            $this->logger->warning($class  . ' does not implements ' . CommandInterface::class);
            return null;
        }

        return $this->container->get($reflectionClass->getShortName());
    }
}
