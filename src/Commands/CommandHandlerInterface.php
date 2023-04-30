<?php

namespace Yumerov\MaxiBot\Commands;

use Discord\Discord;

interface CommandHandlerInterface
{

    public function iterate(Discord $discord): void;
}
