<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

abstract class OnMessageReactStep extends AbstractStep implements StepInterface
{
    use NonStoppingStepTrait;

    abstract public function getMessageFragments(): array;

    abstract public function getReactionEmoji(): string;

    public function execute(): void
    {
        if ($this->message->author?->bot) {
            return;
        }

        $content = mb_strtolower(str_replace(' ', '', $this->message->content));

        foreach ($this->getMessageFragments() as $greeting) {
            if (str_contains($content, $greeting)) {
                $this->message->react($this->getReactionEmoji());
            }
        }
    }
}
