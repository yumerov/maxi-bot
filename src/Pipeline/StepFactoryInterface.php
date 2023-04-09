<?php

namespace Yumerov\MaxiBot\Pipeline;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Yumerov\MaxiBot\Pipeline\Steps\StepInterface;

interface StepFactoryInterface
{

    public function create(string $class, Message $message, Discord $discord): ?StepInterface;
}
