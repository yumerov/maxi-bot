<?php

namespace Yumerov\MaxiBot\Commands;

use Discord\Discord;
use Discord\Parts\Interactions\Command\Option;
use Discord\Parts\Interactions\Interaction;

interface CommandInterface
{

    public function getName(): string;
    public function getDescription(): string;
    public function execute(Interaction $interaction): void;

    /**
     * @param Discord $discord
     * @return Option[]
     */
    public function getOptions(Discord $discord): array;
}
