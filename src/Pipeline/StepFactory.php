<?php

namespace Yumerov\MaxiBot\Pipeline;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;

class StepFactory
{

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ContainerInterface $container
    ) {
    }

    /**
     * @param string $class
     * @param Message $message
     * @param Discord $discord
     *
     * @return AbstractStep|null
     *
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(string $class, Message $message, Discord $discord): ?AbstractStep
    {
        $reflectionClass = new ReflectionClass($class);

        if (!$reflectionClass->isSubclassOf(AbstractStep::class)) {
            $this->logger->warning($class . ' is not child of ' . AbstractStep::class);
            return null;
        }

        if (! $reflectionClass->implementsInterface(StepInterface::class)) {
            $this->logger->warning($class  . ' does not implements ' . AbstractStep::class);
            return null;
        }

        /**
         * @var AbstractStep $step
         */
        $step = $this->container->get($reflectionClass->getShortName());

        $step->setDiscord($discord)->setMessage($message);

        return $step;
    }
}
