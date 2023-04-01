<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;
use Yumerov\MaxiBot\DTO\EnvDTO;
use Yumerov\MaxiBot\Pipeline\AbstractStep;
use Yumerov\MaxiBot\Pipeline\AllowedServerFirewallStep;
use Yumerov\MaxiBot\Pipeline\MaintainerOnlyModeStep;
use Yumerov\MaxiBot\Pipeline\NoSecondBestStep;
use Yumerov\MaxiBot\Pipeline\NotMeFirewallStep;
use Yumerov\MaxiBot\Pipeline\StepInterface;

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
        private readonly EnvDTO $env
    ) {
    }

    /**
     * @throws ReflectionException
     */
    public function __invoke(Message $message, Discord $discord): void
    {
        foreach ($this->steps as $stepClass) {
            $reflectionClass = new ReflectionClass($stepClass);

            if (!$reflectionClass->isSubclassOf(AbstractStep::class)) {
                $this->logger->warning($stepClass . ' is not child of ' . AbstractStep::class);
                continue;
            }

            if (! $reflectionClass->implementsInterface(StepInterface::class)) {
                $this->logger->warning($stepClass  . ' does not implements ' . AbstractStep::class);
                continue;
            }

            /**
             * @var StepInterface $step
             */
            $step = $reflectionClass->newInstance($discord, $message, $this->logger, $this->env);

            if ($step->stops()) {
                $this->logger->debug($stepClass  . ' stops.');
                return;
            }

            $step->execute();
        }
    }
}
