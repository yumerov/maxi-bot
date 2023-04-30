<?php

namespace Yumerov\MaxiBot\Actions;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Psr\Log\LoggerInterface;
use Yumerov\MaxiBot\Exceptions\Exception;
use Yumerov\MaxiBot\Pipeline\StepFactoryInterface;
use Yumerov\MaxiBot\Pipeline\Steps\AllowedServerFirewallStep;
use Yumerov\MaxiBot\Pipeline\Steps\GoodMorningReactionStep;
use Yumerov\MaxiBot\Pipeline\Steps\MaintainerOnlyModeStep;
use Yumerov\MaxiBot\Pipeline\Steps\NoSecondBestStep;
use Yumerov\MaxiBot\Pipeline\Steps\NotMeFirewallStep;

class OnMessageAction
{

    /**
     * @var string[]
     */
    protected array $steps = [
        GoodMorningReactionStep::class,
        NotMeFirewallStep::class,
        AllowedServerFirewallStep::class,
        MaintainerOnlyModeStep::class,
        NoSecondBestStep::class
    ];

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly StepFactoryInterface $factory
    ) {
    }

    /**
     * @param Message $message
     * @param Discord $discord
     * @return void
     * @throws Exception
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
