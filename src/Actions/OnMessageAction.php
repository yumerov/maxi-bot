<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Yumerov\MaxiBot\Exceptions\Exception;
use Yumerov\MaxiBot\Pipeline\AllowedServerFirewallStep;
use Yumerov\MaxiBot\Pipeline\MaintainerOnlyModeStep;
use Yumerov\MaxiBot\Pipeline\NoSecondBestStep;
use Yumerov\MaxiBot\Pipeline\NotMeFirewallStep;
use Yumerov\MaxiBot\Pipeline\StepFactory;

class OnMessageAction
{

    /**
     * @var string[]
     */
    protected array $steps = [
        NotMeFirewallStep::class,
        AllowedServerFirewallStep::class,
        MaintainerOnlyModeStep::class,
        NoSecondBestStep::class
    ];

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly StepFactory $factory
    ) {
    }

    /**
     * @throws Exception
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    public function __invoke(Message $message, Discord $discord): void
    {
        foreach ($this->steps as $stepClass) {
            $step = $this->factory->create($stepClass, $message, $discord);

            if ($step === null) {
                throw new Exception("Class '$stepClass' not found");
            }

            if ($step->stops()) {
                $this->logger->debug($stepClass  . ' stops.');
                return;
            }

            $step->execute();
        }
    }
}
