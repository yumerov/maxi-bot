<?php

namespace Yumerov\MaxiBot\Pipeline\Steps;

class NoSecondBestStep extends AbstractStep implements StepInterface
{

    public function stops(): bool
    {
        return false;
    }

    public function execute(): void
    {
        $this->message->reply('There is no second best!');
    }
}
