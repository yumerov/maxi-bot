<?php

namespace Yumerov\MaxiBot\Commands;

use Discord\Parts\Interactions\Interaction;

interface CommandInterface
{

    public function getName(): string;
    public function getDescription(): string;
    public function execute(Interaction $interaction): void;
}
