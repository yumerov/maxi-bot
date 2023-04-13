<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

class NoSecondBestStep extends AbstractStep implements StepInterface
{

    use NonStoppingStepTrait;

    public function execute(): void
    {
        $this->message->reply('There is no second best!');
    }
}
